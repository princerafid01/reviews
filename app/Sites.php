<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Options;
use Rinvex\Categories\Models\Category;

class Sites extends Model
{

    use \Rinvex\Categories\Traits\Categorizable;

    protected $guarded = [];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'url';
    }

    // cast to array
    public $casts = [ 'metadata' => 'array' ];

    // relationship to reviews
    public function reviews()
    {
        return $this->hasMany( Reviews::class, 'review_item_id', 'id' );
    }

    // relationship to claimer
    public function claimer()
    {
        return $this->belongsTo( User::class, 'claimedBy', 'id');
    }

    // relationship to submitter
    public function submitter()
    {
        return $this->belongsTo( User::class, 'submittedBy', 'id');
    }


    // compute slug
    public function getSlugAttribute() {
    	return route('reviewsForSite', ['site' => $this]);
    }

    // get screenshot
    public function getScreenshotAttribute (  )
    {

        // get licence
        $license = Options::get_option( 'license_key', 'None' );

        if( isset( $this->metadata ) && isset( $this->metadata[ 'logo' ] ) )
            return asset('domain-logos/' . $this->metadata[ 'logo' ]);
        else
            return 'https://usvps.crivion.com/thumbs.php?size=l&url=http://'.$this->url.'&license='.$license.'&site_url='.env( 'APP_URL' );
    }

    // get trustscore attribute 
    /*
    'prettyBad' < 2
    'bad' >= 2 and <= 3
    'good' > 3 and < 4
    'excellent' >= 4
    */
    public function getTrustScoreAttribute() {

        $rating = $this->reviews->avg('rating');

        if( !$rating )
            return __( 'trustscore.notRated' );

        switch( $rating ) {

            case $rating < 2:
                return __( 'trustscore.prettyBad' );
            break;

            case $rating >= 2 && $rating <= 3:
                return __( 'trustscore.bad' );
            break;

            case $rating > 3 && $rating < 4:
                return __( 'trustscore.good' );
            break;

            case $rating >= 4:
                return __( 'trustscore.excellent' );
            break;

            default:
                return __( 'trustscore.notRated' );
            break;

        }

    }

    public function category()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }


}

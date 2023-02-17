<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sites;
use App\Mail\EmailNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mail;
use Options;


class SubmitController extends Controller
{

    // construct
    public function __construct() {
        $this->middleware(['auth', 'verified']);
        
    }


    // submit company form
    public function submitCompanyForm(  ) {
        
        $categories = app('rinvex.categories.category')->all();
        $seo_title = __( 'Submit Company' ) . ' - ' . env( 'APP_NAME' );
        $comparer_options = Options::get_option('site_comparer_attributes');
        $data = [];

        foreach ($categories as $c){
            $data[trim($c->name)] = [];  
            foreach ($c->children as $sub_cat){
                $data[trim($c->name)][trim($sub_cat->name)] = [];
                foreach ($sub_cat->children as $sub_sub_cat){
                    $data[trim($c->name)][trim($sub_cat->name)][] = trim($sub_sub_cat->name);
                }
            }
        }

        $json_encoded_categories = json_encode($data);

        
        return view('submit-company', compact( 'categories', 'seo_title','comparer_options', 'json_encoded_categories' ));

    }


    // process new entry
    public function submitStore ( Request $r )
    {

        $this->validate( $r, [ 'url' => 'required|url' ]);

        // does this url exist?
        if( !urlExists( $r->url ) ) {
            alert()->error(__('This URL could not be reached. Please check for errors'), __('URL Error'));
            return back();
        }

        // parse only domain name
        $uri = parse_url($r->url, PHP_URL_HOST);

        // check for duplicates
        if( Sites::whereUrl( $uri )->exists() ) {
            alert()->error(__('We already have this company listed'), __('Already Exists'));
            return back();
        }

        // save this site
        $site = new Sites;
        $site->url = $uri;
        $site->business_name = $r->name;
        $site->lati = $r->lati;
        $site->longi = $r->longi;
        $site->location = $r->city_region;
        $site->submittedBy = auth()->user()->id;
        $site->save();

        $category = app('rinvex.categories.category')->where('name->en', $r->category_name)->first();
        $sub_category = app('rinvex.categories.category')->where('name->en', $r->sub_category_name)->first();
        $sub_sub_category = app('rinvex.categories.category')->where('name->en', $r->sub_sub_category_name)->first();

        // attach category to this site
        // $this->__updateCategory( $site, $category->id );

        $this->__updateCategoryAndSubcategory($category->slug, $site->id );
        $this->__updateCategoryAndSubcategory($sub_category->slug, $site->id );
        $this->__updateCategoryAndSubcategory($sub_sub_category->slug, $site->id );

        // notify admin by email
        $data[ 'message' ] = sprintf(__('New business added on the website called %s
                              Location: %s
                              Site URL: %s'), 
                                '<strong>'.$r->name.'</strong><br>', 
                                '' . $r->city_region . '<br>', 
                                '<a href="'.$r->url.'">' . $uri . '</a>'
                                );

        $data[ 'intromessage' ] = __('New business added');
        $data[ 'url' ] = route( 'reviewsForSite', [ 'site' => $site->url ]);
        $data[ 'buttonText' ] = __('See Listing');

        Mail::to(Options::get_option( 'adminEmail' ))->send( new EmailNotification( $data ) );

        // set success message
        alert()->success(__('This company has been added and will be reviewed before publishing to our site.'), __('Company Added'));

        // redirect to the new listing
        return redirect()->route( 'home' );


    }

    // set category
    private function __updateCategory( Sites $p, int $categoryId ): object {
        return $p->syncCategories( $categoryId, true);
    }

    private function __updateCategoryAndSubcategory($slug, $site_id)
    {
        $cat_id = DB::table('categories')->select('id')->whereSlug($slug)->first();
        if ($cat_id) {
            $sub_cat_ids = DB::table('categorizables')->insert([
                'category_id' => $cat_id->id,
                'categorizable_id' => $site_id,
                'categorizable_type' => Sites::class,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Support\Traits\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class AppCategory extends Model
{
    use HasTranslations;
    // use HasRecursiveRelationships;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';
    protected $guarded = [];
    public $translatable = [
        'name',
        'description',
    ];

    public function scopeRoot($query)
    {
        $query->whereNull('parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}

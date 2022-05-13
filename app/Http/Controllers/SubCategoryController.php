<?php

namespace App\Http\Controllers;

use App\AppCategory;
use App\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Rinvex\Categories\Models\Category;

class SubCategoryController extends Controller
{
    public function create(Request $request)
    {
        // Need Root (Main) Category id
        $main_category_id = $request->category_id;
        $now = Carbon::now()->toDateTimeString();
        $data = [];

        // Iterate over Sub Categories and Sub Sub Categories
        foreach ($request->subcategory_data as $key => $sub_categories) {
            // reset can take the first item from an array
            $sub_category = @reset(array_keys($sub_categories));
            //  Comma Exists  
            $sub_sub_categories = @reset(array_values($sub_categories));

            $sub_category_slug = Str::slug($sub_category);

            $sub_category_id = DB::table('categories')->where(['parent_id' => $main_category_id , 'slug' => $sub_category_slug ])->pluck('id')->first();

            if (!!$sub_category_id) {

                // Upsert The Category Model
                $sub_sub_categories_array = explode(',', $sub_sub_categories);

                foreach ($sub_sub_categories_array as $key => $sub_sub_category) {
                    $sub_sub_category_slug = Str::slug($sub_sub_category);
                    $category = AppCategory::updateOrCreate(
                        ['slug' => $sub_sub_category_slug , 'parent_id' => $sub_category_id],
                        [
                            'name' => [
                                'en' =>  $sub_sub_category
                            ],
                            'slug' => $sub_sub_category_slug,
                            'parent_id' => $sub_category_id,
                        ]
                    );
                }
            } else {
                $new_sub_category = app('rinvex.categories.category')->create(
                    [
                        'name' => [
                            'en' =>  $sub_category
                        ],
                        'slug' => $sub_category_slug,
                        'parent_id' => $main_category_id,
                    ]
                );
                // $new_sub_category_id = $new_sub_category->id;

                // Upsert The Category Model
                $sub_sub_categories_array = explode(',', $sub_sub_categories);
                foreach ($sub_sub_categories_array as $key => $sub_sub_category) {
                    $sub_sub_category_slug = Str::slug($sub_sub_category);
                    $category = AppCategory::updateOrCreate(
                        ['slug' => $sub_sub_category_slug],
                        [
                            'name' => [
                                'en' =>  $sub_sub_category
                            ],
                            'slug' => $sub_sub_category_slug,
                            'parent_id' => $new_sub_category->id,
                        ]
                    );
                }
            }

            // $prev_sub_sub_categories = AppCategory::where('parent_id', $new_sub_category_id)->get();
            // $prev_sub_sub_categories_id = $prev_sub_sub_categories->pluck('id')->toArray();


            // // explode comma in sub sub categories 
            // $sub_sub_categories_array = explode(',', $sub_sub_categories);

            // foreach ($sub_sub_categories_array as $key => $sub_sub_category) {
            //     $sub_sub_category_slug = Str::slug($sub_sub_category);

            //     $current_sub_sub_category = Category::where('slug', $sub_sub_category_slug)->first();
            //     if ($current_sub_sub_category) {
            //         $prev_sub_sub_categories_id = array_diff($prev_sub_sub_categories_id, [$current_sub_sub_category->id]);
            //     } else {
            //         $new_sub_category = app('rinvex.categories.category')->create(
            //             [
            //                 'name' => [
            //                     'en' =>  $sub_sub_category
            //                 ],
            //                 'slug' => $sub_sub_category_slug,
            //                 'parent_id' => $new_sub_category_id,
            //             ]
            //         );
            //     }
            // }

            // foreach ($prev_sub_sub_categories as $key => $value) {
            //     $value->delete();
            // }
        }

        return ['msg' => 'Categories Created Successfully'];
    }
}

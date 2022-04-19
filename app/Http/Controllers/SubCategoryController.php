<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function create(Request $request)
    {
        $now = Carbon::now()->toDateTimeString();
        $data = [];
        foreach ($request->subcategory_data as $key => $sub_categories) {
            // reset can take the first item from an array
            $sub_category = @reset(array_keys($sub_categories));
            $sub_sub_categories = @reset(array_values($sub_categories));

            $data[] = [
                'category_id' => (int) $request->category_id,
                'name' => $sub_category,
                'sub_sub_categories' => $sub_sub_categories,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        $subcategories = Subcategory::where('category_id' , (int) $request->category_id)->get();
        foreach ($subcategories as $subcategory) {
            $subcategory->delete();
        }


        Subcategory::insert($data);
        return ['data' => $data];
    }
}

<?php

namespace App\Imports;

use App\Sites;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;


class SitesImport implements ToModel, WithHeadingRow, SkipsOnError
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $url = str_replace(['http://', 'https://', '/'], '', $row['url']);
        $category_slug = Str::slug($row['category'] ?? '');
        $sub_category_slug =  Str::slug($row['sub_category'] ?? '');
        $sub_sub_category_slug = Str::slug($row['sub_sub_category'] ?? '');

        $data = new Sites([
            'url' => $url,
            'business_name' => $row['business_name'],
            'submittedBy' => 1,
            'lati' => $row['latitude'],
            'longi' => $row['longitude'],
            'location' => $row['location'],
            'publish' => 'Yes'
        ]);


        $cat_id = DB::table('categories')->select('id')->whereSlug($category_slug)->first()->id;

        // if ($cat_id) {
        //     $cat_ids = DB::table('categorizables')->insert([
        //         'category_id' => $cat_id,
        //         'categorizable_id' => $data->id,
        //         'categorizable_type' => Sites::class,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }

        // $sub_cat_id = DB::table('categories')->select('id')->whereSlug($sub_category_slug)->first()->id;
        // if ($sub_cat_id) {
        //     $sub_cat_ids = DB::table('categorizables')->create([
        //         'category_id' => $sub_cat_id,
        //         'categorizable_id' => $data->id,
        //         'categorizable_type' => 'App/Sites',
        //     ]);
        // }

        // $sub_sub_cat_id = DB::table('categories')->select('id')->whereSlug($sub_sub_category_slug)->first()->id;
        // if ($sub_sub_cat_id) {
        //     $sub_sub_cat_ids = DB::table('categorizables')->create([
        //         'category_id' => $sub_sub_cat_id,
        //         'categorizable_id' => $data->id,
        //         'categorizable_type' => 'App/Sites',
        //     ]);
        // }

        return $data;
    }

    public function onError(Throwable $e)
    {
        return back()->withMsg($e->getMessage())->withStatus('error');
    }
}

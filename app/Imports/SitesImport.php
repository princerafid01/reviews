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

        $data = new Sites([
            'url' => $url,
            'business_name' => $row['business_name'],
            'submittedBy' => 1,
            'lati' => $row['latitude'],
            'longi' => $row['longitude'],
            'location' => $row['location'],
            'publish' => 'Yes'
        ]);

        return $data;
    }

    public function onError(Throwable $e)
    {
        return back()->withMsg($e->getMessage())->withStatus('error');
    }
}

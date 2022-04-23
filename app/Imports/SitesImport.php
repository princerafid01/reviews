<?php

namespace App\Imports;

use App\Sites;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
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
        $url = str_replace(['http://' , 'https://' , '/'], '' ,$row['url']); 
        
        return new Sites([
            'url' => $url, 
            'business_name' => $row['business_name'], 
            'submittedBy' => 1, 
            'lati' => $row['latitude'], 
            'longi' => $row['longitude'], 
            'location' => $row['location'], 
            'publish' => 'Yes'
        ]);
    }

    public function onError(Throwable $e)
    {
        return back()->withMsg($e->getMessage())->withStatus('error');
    }
}

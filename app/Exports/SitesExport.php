<?php

namespace App\Exports;

use App\Sites;
use Maatwebsite\Excel\Concerns\FromCollection;

class SitesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([['URL' , 'Business Name','Latitude','Longitude','Location']]);
    }
}

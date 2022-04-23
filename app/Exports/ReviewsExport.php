<?php

namespace App\Exports;

use App\Reviews;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReviewsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([['Review Item Url' , 'Rating','Review Title' , 'Review Content']]);
    }
}

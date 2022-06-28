<?php

namespace App\Imports;

use App\Reviews;
use App\Sites;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;


class ReviewsImport implements ToModel, WithHeadingRow, SkipsOnError
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $site = Sites::where('url', $row['review_item_url'])->first();

        if ($site) {
            return new Reviews([
                'review_item_id' => $site->id,
                'rating' => $row['rating'],
                'review_title' => $row['review_title'],
                'review_content' => $row['review_content'],
                'publish' => 'Yes',
            ]);
        }
    }

    public function onError(Throwable $e)
    {
        return back()->withMsg($e->getMessage())->withStatus('error');
    }
}

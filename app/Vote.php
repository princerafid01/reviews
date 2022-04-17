<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    // no timestamps, please
    public $timestamps = false;

    // relation to review
    public function review() {
    	return $this->belongsTo( Reviews::class );
    }
}

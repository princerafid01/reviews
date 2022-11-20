<?php

namespace App\Http\Controllers;

use App\AppCategory;
use App\Reviews;
use App\User;
use App\Http\Controllers\Controller;
use App\Promoted;
use Carbon\Carbon;
use Cache;
use DB;

class HomeController extends Controller
{
    // homepage
    public function __invoke()
    {

        // do we have a return to parameter after login/signup?
        if (session()->has('return')) {
            $ret = session('return');
            session()->forget('return');

            return redirect($ret);
        }

        $reviews = Reviews::with('site')
            ->wherePublish('Yes')
            ->latest()
            ->take(12)
            ->get();

        $categories = AppCategory::root()->get();
        // $categories = AppCategory::all();

        return view('home', ['activeNav' => 'home', 'reviews' => $reviews , 'categories' => $categories]);
    }
}

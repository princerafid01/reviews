<?php

namespace App\Http\Controllers;

use App\Sites;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $selected_products = Arr::pluck(json_decode($request->productsString), 'site_url');
        $sites = Sites::whereIn('url', $selected_products)->orderBy('id' , 'desc')->get();
        return view('compare-table' , compact('sites' , $sites));
    }
}

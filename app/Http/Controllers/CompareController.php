<?php

namespace App\Http\Controllers;

use App\Sites;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $sites = Sites::orderBy('id' , 'desc')->take(3)->get();
        return view('compare-table' , compact('sites' , $sites));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function discover()
    {
        return view('discover');
    }

    public function auth()
    {
        return view('auth');
    }
}

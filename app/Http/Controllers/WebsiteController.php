<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
public function home()
{
    return view('website.home');
}

public function about()
{
    return view('website.about');
}

public function activities()
{
    return view('website.activities');
}

public function admissions()
{
    return view('website.admissions');
}

public function news()
{
    return view('website.news');

}

public function contact()
{
    return view('website.contact');
}
}

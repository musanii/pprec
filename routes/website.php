<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::controller(WebsiteController::class)->group(function(){
Route::get('/', 'home')->name('website.home');
Route::get('/about', 'about')->name('website.about');
Route::get('/activities', 'activities')->name('website.activities');
Route::get('/admissions', 'admissions')->name('website.admissions');
Route::get('/news', 'news')->name('website.news');
Route::get('/contact', 'contact')->name('website.contact');

});

Route::get('/{slug}', [WebsiteController::class, 'page'])
    ->name('website.page');
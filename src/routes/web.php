<?php

use Illuminate\Support\Facades\Route;

// Route::get('/home', function () {
//     return view('home');
// });

Route::get('/welcome', function () {
    return view('welcome');
});

Route::view('home', 'home')->name('home');

Route::view('about', 'about')->name('about');

Route::view('contact', 'contact')->name('contact');

Route::view('article', 'article')->name('article');
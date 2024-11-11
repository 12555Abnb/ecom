<?php

use App\Http\Controllers\Admin\homeBannerController;
use App\Http\Controllers\Admin\profileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin/index');
});

//profile section
Route::get('/profile', [profileController::class, 'index']);
Route::post('/saveProfile', [profileController::class, 'store']);

//Home Banner Section
Route::get('/home_banner', [homeBannerController::class, 'index']);
Route::post('/updateHomeBanner', [homeBannerController::class, 'store']);

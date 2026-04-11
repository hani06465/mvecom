<?php

use Illuminate\Support\Facades\Route;
// we include this for route of our Admin
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// the rout for Admin
//Route::resource('admin/dashboard',AdminController::class)->only(['index']);  // we updated this with ..

Route::prefix('admin')->group(function () {
    //Dashboard route
    Route::resource('dashboard', AdminController::class)->only(['index']);
});



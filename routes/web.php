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
    //show login from
    Route::get('login', [AdminController::class, 'create'])->name('admin.login');
    //Dashboard route
    // i avoid this usage and i enserted this beacuse i want first to loging the admin before access it or it restricts from direct acess.
   //Route::resource('dashboard', AdminController::class)->only(['index']);
   // here now we can access this dashboard after we 
   Route::group(['middleware' => ['admin']],function() {
    //Dashboard
    // we then enter the dashboard route to this beacause we need first to  loginig first.
    Route::resource('dashboard',AdminController::class)->only(['index']);
   });
});



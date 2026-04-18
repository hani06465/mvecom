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
    // Handle login form submission (we created it to handle login form submission)
    Route::post('login',[AdminController::class, 'store'])->name('admin.login.request');
    //Dashboard route
    // i avoid this usage and i enserted this beacuse i want first to loging the admin before access it or it restricts from direct acess.
   //Route::resource('dashboard', AdminController::class)->only(['index']);
   // here now we can access this dashboard after we 
   Route::group(['middleware' => ['admin']],function() {
    //Dashboard
    // we then enter the dashboard route to this beacause we need first to  loginig first.
    Route::resource('dashboard',AdminController::class)->only(['index']);
    // Display update password page 
    Route::get('update-password', [AdminController::class, 'edit'])->name('admin.update-password');
    // Admin verify password 
    Route::post('verify-password',[AdminController::class, 'verifyPassword'])->name('admin.verify.password');
    // update password route
     Route::post('admin/update-password',[AdminController::class, 'updatePasswordRequest'])->name('admin.update-password.request');
    //Admin logout
    Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');
   });
});



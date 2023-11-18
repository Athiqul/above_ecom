<?php

use App\Http\Controllers\Admin\AdminProfile;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dash;
use App\Http\Controllers\Customer\Home;
use App\Http\Controllers\Vendor\Dash as VendorDash;
use App\Http\Controllers\Vendor\VendorProfile;
use App\Http\Controllers\Customer\Auth as CustomerAuth;
use App\Http\Controllers\Common\Brand;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Admin Dashboard
Route::prefix('admin')->group(function (){
    Route::middleware(['auth','role:admin'])->group(function(){
         Route::get('dashboard',Dash::class)->name('admin.dashboard');
         Route::get('profile',[AdminProfile::class,'show'])->name('admin.profile');
         Route::patch('profile-update',[AdminProfile::class,'profileUpdate'])->name('admin.profileUpdate');
         Route::get('change-password',[AdminProfile::class,'changePassword'])->name('admin.password_change');
         Route::patch('change-password',[AdminProfile::class,'storePassword'])->name('admin.password_store');
    });

    //Brands
    Route::controller(Brand::class)->group( function (){
         //Show All brands
         Route::get('all-brand','index')->name('all.brand');
         Route::get('add-brand','add')->name('brand.add');
    });
});


//Vendor Dashboard
Route::prefix('vendor')->middleware(['auth','role:vendor'])->group(function(){
    Route::get('dashboard',VendorDash::class)->name('vendor.dashboard');
    Route::get('profile',[VendorProfile::class,'show'])->name('vendor.profile');
    Route::patch('profile-update',[VendorProfile::class,'store'])->name('vendor.profileUpdate');
    Route::get('change-password',[VendorProfile::class,'changePassword'])->name('vendor.password_change');
    Route::patch('change-password',[VendorProfile::class,'storePassword'])->name('vendor.password_store');

});

//Visitors view

Route::get('/',[Home::class,'index'] )->name('customer.home');
Route::get('/sign-in',[CustomerAuth::class,'signIn'])->name('customer.login');
Route::get('/sign-up',[CustomerAuth::class,'register'])->name('customer.register');
Route::get('/forget-password',[CustomerAuth::class,'forgot'])->name('customer.forgot');

//Customer
Route::prefix('customer')->middleware(['auth','role:user'])->group(function (){
      Route::get('dashboard',[Home::class,'dashboard'])->name('customer.dashboard');
      Route::patch('account-info-update',[Home::class,'profileUpdate'])->name('customer.profile.update');
      Route::patch('change-password',[Home::class,'storePassword'])->name('customer.change.password');
      Route::get('logout',[Home::class,'destroy'])->name('customer.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

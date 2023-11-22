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
use App\Http\Controllers\Common\Category;
use App\Http\Controllers\Common\Products;
use App\Http\Controllers\Common\SubCategory;
use App\Http\Controllers\Common\Vendor;

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


    //Brands
    Route::controller(Brand::class)->prefix('brand')->group( function (){
         //Show All brands
         Route::get('all-brand','index')->name('all.brand');
         Route::get('add-brand','add')->name('brand.add');
         Route::post('add-brand','store')->name('brand.create');
         Route::get('edit-brand/{id}','edit')->name('brand.edit');
         Route::patch('update/{id}','update')->name('brand.update');
         Route::get('brand-delete/{id}','delete')->name('brand.delete');
    });

    Route::controller(Category::class)->prefix('category')->group(function(){

           Route::get('categories','index')->name('category.list');
           Route::get('add-category','add')->name('category.add');
           Route::post('add-category','store')->name('category.create');
           Route::get('edit-category/{id}','edit')->name('catedory.edit');
           Route::patch('update/{id}','update')->name('category.update');
           Route::get('category-delete/{id}','delete')->name('category.delete');
    });

  //Sub category route
    Route::controller(SubCategory::class)->prefix('sub-category')->group(function(){

        Route::get('/','index')->name('sub.category.list');
        Route::get('add-sub-category','add')->name('sub.category.add');
        Route::post('add-sub-category','store')->name('sub.category.create');
        Route::get('edit-sub-category/{id}','edit')->name('sub.catedory.edit');
        Route::patch('update/{id}','update')->name('sub.category.update');
        Route::get('delete/{id}','delete')->name('sub.category.delete');
 });

 //Vendor Manage
   Route::controller(Vendor::class)->prefix('vendor-manage')->group(function(){

          Route::get('active-list','showActive')->name('vendor.active.list');
          Route::get('inactive-list','showInActive')->name('vendor.inactive.list');
          Route::get('profile/{id}','vendorDetails')->name('vendor.profile.details');
          Route::get('change-status/{id}','changeStatus')->name('vendor.status.change');
   });


   //Product management
   Route::controller(Products::class)->prefix('product-manage')->group(function(){

    Route::get('','index')->name('product.list');
    Route::get('add-product','add')->name('product.add');
    Route::post('add-product','store')->name('product.save');
    Route::get('/subcategory/{id}','subCategory')->name('ajax.subcategory');
    Route::get('edit-product/{id}','edit')->name('product.edit');
    Route::put('info-update/{id}','updateInfo')->name('product.update.info');
    Route::patch('main-image-update/{id}','updateImage')->name('product.update.image');
    Route::patch('multi-image-update/{id}','updateMultiImage')->name('product.update.multi');
    Route::post('add-multi-image/{id}','addMultiImage')->name('product.add.multi');
    Route::get('delete-product/{id}','deleteMulti')->name('product.image.delete');
    Route::get('status-product/{id}','changeStatus')->name('product.status');



});

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
//Vendor Register
Route::get('/vendor-register',[VendorProfile::class,'vendorRegister'])->name('vendor.register');
Route::post('vendor-register',[VendorProfile::class,'storeVendor'])->name('vendor.create');

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

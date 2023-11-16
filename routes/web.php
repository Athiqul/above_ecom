<?php

use App\Http\Controllers\Admin\AdminProfile;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dash;
use App\Http\Controllers\Vendor\Dash as VendorDash;
use App\Http\Controllers\Vendor\VendorProfile;

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
});


//Vendor Dashboard
Route::prefix('vendor')->middleware(['auth','role:vendor'])->group(function(){
    Route::get('dashboard',VendorDash::class)->name('vendor.dashboard');
    Route::get('profile',[VendorProfile::class,'show'])->name('vendor.profile');
    Route::patch('profile-update',[VendorProfile::class,'store'])->name('vendor.profileUpdate');
    Route::get('change-password',[VendorProfile::class,'changePassword'])->name('vendor.password_change');
    Route::patch('change-password',[VendorProfile::class,'storePassword'])->name('vendor.password_store');

});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

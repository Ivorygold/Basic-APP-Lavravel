<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\AboutController;

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

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin all Route
Route::controller('adminController')->group(function () {
    Route::get('/admin/logout', [adminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [adminController::class, 'Profile'])->name('admin.profile');
    Route::get('/edit/profile', [adminController::class, 'EdithProfile'])->name('edit.profile');
    Route::post('/store/profile', [adminController::class, 'StoreProfile'])->name('store.profile');

    Route::get('/change/password', [adminController::class, 'ChangePassword'])->name('change.password');
    Route::post('/update/password', [adminController::class, 'UpdatePassword'])->name('update.password');
    
});

//Home Slide all Route
Route::controller('HomeSliderController')->group(function () {
    Route::get('/home/slide', [HomeSliderController::class, 'HomeSlider'])->name('home.slide');
    Route::post('/update/slider', [HomeSliderController::class, 'UpdateSlider'])->name('update.slider');
   
    
});

//About page all Route
Route::controller('AboutController')->group(function () {
    Route::get('/about/page', [AboutController::class, 'AboutPage'])->name('about.page');
    Route::post('/update/about', [AboutController::class, 'UpdateAbout'])->name('update.about');
    
    Route::get('/about', [AboutController::class, 'HomeAbout'])->name('home.about');
   
   
    
});


require __DIR__.'/auth.php';

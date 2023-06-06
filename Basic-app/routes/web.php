<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\Home\BlogCategoryController;
use App\Http\Controllers\Home\BlogController;

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
    Route::get('/about/multi/image', [AboutController::class, 'AboutMultiImage'])->name('about.multi.image');
    Route::post('/store/multi/image', [AboutController::class, 'StoreMultiImage'])->name('store.multi.image');
    Route::get('/all/multi/image', [AboutController::class, 'AllMultiImage'])->name('all.multi.image');
    Route::get('/edit/multi/image/{id}', [AboutController::class, 'EditMultiImage'])->name('edit.multi.image');
    Route::post('/update/multi/image', [AboutController::class, 'UpdateMultiImage'])->name('update.multi.image');
    Route::get('/delete/multi/image/{id}', [AboutController::class, 'DeleteMultiImage'])->name('delete.multi.image');
   
   
    
});

//Portfolio Slide all Route
Route::controller('PortfolioController')->group(function () {
    Route::get('/all/Portfolio', [PortfolioController::class, 'AllPortfolio'])->name('all.Portfolio');
    Route::get('/add/Portfolio', [PortfolioController::class, 'AddPortfolio'])->name('add.Portfolio');
    Route::post('/store/Portfolio', [PortfolioController::class, 'StorePortfolio'])->name('store.Portfolio');
    Route::get('/edit/Portfolio/{id}', [PortfolioController::class, 'EditPortfolio'])->name('edit.portfolio');
    Route::post('/update/Portfolio', [PortfolioController::class, 'UpdatePortfolio'])->name('update.Portfolio');
    Route::get('/delete/Portfolio/{id}', [PortfolioController::class, 'DeletePortfolio'])->name('delete.portfolio');
    Route::get('/portfolio/details/{id}', [PortfolioController::class, 'PortfolioDetails'])->name('portfolio.details');
});

//Blog Slide all Route
Route::controller('BlogCategoryController')->group(function () {
    Route::get('/all/blog/category', [BlogCategoryController::class, 'AllBlogCategory'])->name('all.blog.category');
    Route::get('/add/blog/category', [BlogCategoryController::class, 'AddBlogCategory'])->name('add.blog.category');
    Route::post('/store/blog/category', [BlogCategoryController::class, 'StoreBlogCategory'])->name('store.blog.category');
    Route::get('/edit/blog/category/{id}', [BlogCategoryController::class, 'EditBlogCategory'])->name('edit.blog.category');
    Route::post('/update/blog/category/{id}', [BlogCategoryController::class, 'UpdateBlogCategory'])->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', [BlogCategoryController::class, 'DeleteBlogCategory'])->name('delete.blog.category');
   
    
});

//Blog all Route
Route::controller('BlogController')->group(function () {
    Route::get('/all/blog', [BlogController::class, 'AllBlog'])->name('all.blog');
    Route::get('/add/blog', [BlogController::class, 'AddBlog'])->name('add.blog');
    Route::post('/store/blog', [BlogController::class, 'StoreBlog'])->name('store.blog');
   
   
    
});


require __DIR__.'/auth.php';
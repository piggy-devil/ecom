<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SectionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // All the admin routes will be defined here
    Route::match(['get', 'post'], '/', 'AdminController@login');

    Route::group(['middleware' => 'admin'], function () {

        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('settings', 'AdminController@settings');
        Route::get('logout', 'AdminController@logout');
        Route::post('check-current-pwd', 'AdminController@chkCurrentPassword');
        Route::post('update-current-pwd', 'AdminController@updateCurrentPassword');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        // Sections
        Route::get('sections', 'SectionController@sections');
        Route::post('update-section-status', 'SectionController@updateSectionStatus');

        // Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');

        // Products
        Route::get('products', 'ProductController@products');
        Route::post('update-product-status', 'ProductController@updateProductStatus');
        Route::get('delete-product/{id}', 'ProductController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct');
    });
});

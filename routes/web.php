<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

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

        // Brands
        Route::get('brands', 'BrandController@brands');
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');

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
        Route::get('delete-product-image/{id}', 'ProductController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductController@deleteProductVideo');

        // Attributes
        Route::match(['get', 'post'], 'add-attributes/{id?}', 'ProductController@addAttributes');
        Route::post('edit-attributes/{id?}', 'ProductController@editAttributes');
        Route::post('update-attribute-status', 'ProductController@updateAttributeStatus');
        Route::get('delete-attribute/{id}', 'ProductController@deleteAttribute');

        // Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductController@addImages');
        Route::post('update-image-status', 'ProductController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductController@deleteImage');
        
        // Banners
        Route::get('banners', 'BannerController@banners');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannerController@addEditBanner');
        Route::post('update-banner-status', 'BannerController@updateBannerStatus');
        Route::get('delete-banner/{id}', 'BannerController@deleteBanner');
        
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function(){
    // Home Page Route
    Route::get('/', 'IndexController@index');

    // Listing/Categories Route
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach($catUrls as $url) {
        Route::get('/'.$url, 'ProductController@listing');
    }

    // Product Detail Route
    Route::get('/product/{id}', 'ProductController@detail');

    // Get Product Attribute Price
    Route::post('/get-product-price', 'ProductController@getProductPrice');

    // Add to Cart Route
    Route::post('/add-to-cart', 'ProductController@addToCart');

    // Shopping Cart Route
    Route::get('/cart', 'ProductController@cart');

    // Update Cart Item Quantity
    Route::post('/update-cart-item-qty', 'ProductController@updateCartItemQty');

    // Delete Cart Item Quantity
    Route::post('/delete-cart-item', 'ProductController@deleteCartItem');

});
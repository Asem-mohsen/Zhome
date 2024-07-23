<?php
// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SubscribersController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\ShopOrdersController;
use App\Http\Controllers\Admin\ToolsOrdersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\UserController;
// Authentication
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleLoginController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',   [AuthenticatedSessionController::class, 'apiLogin']);
Route::post('/register',[RegisteredUserController::class,       'store']);


Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->prefix('Users')->name('Users.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{user}/profile', 'profile')->name('profile');
    });

    Route::prefix('Admins')->name('Admins.')->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{admin}/edit', 'edit')->name('edit');
            Route::get('/{admin}/profile', 'profile')->name('profile');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/{admin}/update', 'update')->name('update');
            Route::delete('/{admin}/delete', 'destroy')->name('delete');
        });
    });

});

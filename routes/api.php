<?php
// Admin
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BrandsController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\PlatformsController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\SubcategoriesController;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\SubscribersController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\FeatureController;
use App\Http\Controllers\API\CollectionsController;
use App\Http\Controllers\API\SalesController;
use App\Http\Controllers\API\PromocodesController;
use App\Http\Controllers\API\ShopOrdersController;
use App\Http\Controllers\API\ToolsOrderController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\UserController;
// Authentication
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Auth\GoogleLoginController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',   [AuthenticatedSessionController::class, 'apiLogin']);
Route::post('/register',[RegisteredUserController::class,       'apiStore']);
Route::post('/send-email',[VerifyEmailController::class,        'send']);
Route::post('/verify-code',[VerifyEmailController::class,       'verify']);


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
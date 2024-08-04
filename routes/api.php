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
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\GoogleLoginController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Authentication

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(VerifyEmailController::class)->group(function(){
        Route::post('/send-email' ,'send'  );
        Route::post('/verify-code','verify');
    });
    Route::prefix('logout')->group(function(){
        Route::controller(LogoutController::class)->group(function(){
            Route::post('/current', 'current');
            Route::post('/other', 'other');
            Route::post('/all', 'all');
        });
    });
});

Route::post('/login',   [AuthenticatedSessionController::class, 'apiLogin']);
Route::post('/register',[RegisteredUserController::class,       'apiStore']);

Route::middleware(['auth:sanctum' , 'admin'])->group(function () {

    Route::prefix('admins')->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/', 'index');
            Route::get('/{admin}/edit', 'edit');
            Route::get('/{admin}/profile', 'profile');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::put('/{admin}/update', 'update');
            Route::delete('/{admin}/delete', 'destroy');
        });
    });
    
    Route::prefix('products')->group(function(){
        Route::controller(ProductsController::class)->group(function(){
            Route::get('/products', 'index');
            Route::get('/create', 'create');
            Route::get('/{product}/edit', 'edit');
            Route::get('/{product}/show', 'show');
            Route::get('/{product}/userView', 'userShow');
            Route::post('/store', 'store');
            Route::put('/{product}/update', 'update');
            Route::delete('/{product}/delete', 'destroy');
        });
    });
    
    Route::controller(UserController::class)->prefix('Users')->name('Users.')->group(function(){
        Route::get('/', 'index');
        Route::get('/{user}/profile', 'profile');
    });




    
});
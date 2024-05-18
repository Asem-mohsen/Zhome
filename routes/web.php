<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Admin.index');
})->name('index');


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
Route::prefix('Roles')->name('Roles.')->group(function(){
    Route::controller(RolesController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{role}/edit', 'edit')->name('edit');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/{role}/update', 'update')->name('update');
        Route::delete('/{role}/delete', 'destroy')->name('delete');
    });
});
Route::prefix('Products')->name('Products.')->group(function(){
    Route::controller(ProductController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::get('/{product}/show', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/{product}/update', 'update')->name('update');
        Route::delete('/{product}/delete', 'destroy')->name('delete');
    });
});
Route::prefix('Brands')->name('Brands.')->group(function(){
    Route::controller(BrandController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{brand}/edit', 'edit')->name('edit');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/{brand}/update', 'update')->name('update');
        Route::delete('/{brand}/delete', 'destroy')->name('delete');
    });
});
Route::prefix('Category')->name('Category.')->group(function(){
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{category}/edit', 'edit')->name('edit');
        Route::get('/create', 'create')->name('create');
        Route::get('/{category}/show', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::put('/{category}/update', 'update')->name('update');
        Route::delete('/{category}/delete', 'destroy')->name('delete');
    });
    Route::prefix('Subcategory')->name('Subcategory.')->group(function(){
        Route::controller(SubcategoryController::class)->group(function(){
            Route::get('/{subcategory}/edit', 'edit')->name('edit');
            Route::get('/{category}/create', 'create')->name('create');
            Route::post('/{category}/store', 'store')->name('store');
            Route::put('/{subcategory}/update', 'update')->name('update');
            Route::delete('/{subcategory}/delete', 'destroy')->name('delete');
        });
    });
});
Route::prefix('Platform')->name('Platform.')->group(function(){
    Route::controller(PlatformController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{platform}/edit', 'edit')->name('edit');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/{platform}/update', 'update')->name('update');
        Route::delete('/{platform}/delete', 'destroy')->name('delete');
    });
});

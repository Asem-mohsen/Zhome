<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Admin.index');
});


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
        Route::delete('/{admin}/delete', 'delete')->name('delete');
    });
});
Route::prefix('Roles')->name('Roles.')->group(function(){
    Route::controller(RolesController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{role}/edit', 'edit')->name('edit');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/{role}/update', 'update')->name('update');
        Route::delete('/{role}/delete', 'delete')->name('delete');
    });
});
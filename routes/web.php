<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SubscribersController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\ShopOrdersController;
use App\Http\Controllers\Admin\ToolsOrdersController;
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
        Route::get('/subcategories/{categoryId}', 'getSubcategories')->name('getSubcategories');
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

Route::prefix('Payment')->name('Payment.')->group(function(){
    Route::controller(PaymentController::class)->group(function(){
        Route::get('/', 'index')->name('index');
    });
});

Route::prefix('Subscribers')->name('Subscribers.')->group(function(){
    Route::controller(SubscribersController::class)->group(function(){
        Route::get('/', 'index')->name('index');
    });
});

Route::prefix('Contact')->name('Contact.')->group(function(){
    Route::controller(ContactController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{Contact}/edit', 'edit')->name('edit');
    });
});

Route::prefix('Inventory')->name('Inventory.')->group(function(){
    Route::controller(InventoryController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{Inventory}/edit', 'edit')->name('edit');
    });
});

Route::prefix('Sales')->name('Sales.')->group(function(){
    Route::controller(SalesController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/{sales}/edit', 'edit')->name('edit');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/{sales}/update', 'update')->name('update');
        Route::delete('/{sales}/delete', 'destroy')->name('delete');
    });
    Route::prefix('Promocode')->name('Promocode.')->group(function(){
        Route::controller(PromocodeController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{promocode}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/{promocode}/update', 'update')->name('update');
            Route::delete('/{promocode}/delete', 'destroy')->name('delete');
        });
    });
});

Route::prefix('Orders')->name('Orders.')->group(function(){
    Route::prefix('ShopOrders')->name('ShopOrders.')->group(function(){
        Route::controller(ShopOrdersController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{shoporder}/show', 'show')->name('show');
            Route::delete('/{shoporder}/delete', 'destroy')->name('delete');
        });
    });
    Route::prefix('ToolsOrders')->name('ToolsOrders.')->group(function(){
        Route::controller(ToolsOrdersController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{toolsorders}/show', 'show')->name('show');
            Route::delete('/{toolsorders}/delete', 'destroy')->name('delete');
        });
    });
});
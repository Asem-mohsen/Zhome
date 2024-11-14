<?php

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\ShopOrdersController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SubscribersController;
use App\Http\Controllers\Admin\ToolsOrdersController;
use App\Http\Controllers\Admin\UserController;
// Authentication
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class,       'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class,       'store']);
});

Route::get('/google-login', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::post('/google-login', [GoogleLoginController::class, 'handleGoogleLogin'])->name('auth.google.callback');

// Admin Routes
Route::middleware('auth.admin')->group(function () {

    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/Dashboard', 'index')->name('Dashboard.index');
    });

    Route::controller(UserController::class)->prefix('Users')->name('Users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}/profile', 'profile')->name('profile');
    });

    Route::prefix('Admins')->name('Admins.')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::get('/{user}/profile', 'profile')->name('profile');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/{user}/update', 'update')->name('update');
            Route::delete('/{user}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Roles')->name('Roles.')->group(function () {
        Route::controller(RolesController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{role}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/{role}/update', 'update')->name('update');
            Route::delete('/{role}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Products')->name('Products.')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{product}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::get('/subcategories/{categoryId}', 'getSubcategories')->name('getSubcategories');
            Route::post('/store', 'store')->name('store');
            Route::put('/{product}/update', 'update')->name('update');
            Route::delete('/{product}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Brands')->name('Brands.')->group(function () {
        Route::controller(BrandController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{brand}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/{brand}/update', 'update')->name('update');
            Route::delete('/{brand}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Category')->name('Category.')->group(function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{category}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::get('/{category}/show', 'show')->name('show');
            Route::post('/store', 'store')->name('store');
            Route::put('/{category}/update', 'update')->name('update');
            Route::delete('/{category}/delete', 'destroy')->name('delete');
        });
        Route::prefix('Subcategory')->name('Subcategory.')->group(function () {
            Route::controller(SubcategoryController::class)->group(function () {
                Route::get('/{subcategory}/edit', 'edit')->name('edit');
                Route::get('/{category}/create', 'create')->name('create');
                Route::post('/{category}/store', 'store')->name('store');
                Route::put('/{subcategory}/update', 'update')->name('update');
                Route::delete('/{subcategory}/delete', 'destroy')->name('delete');
            });
        });
    });

    Route::prefix('Platform')->name('Platform.')->group(function () {
        Route::controller(PlatformController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{platform}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::put('/{platform}/update', 'update')->name('update');
            Route::delete('/{platform}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Payment')->name('Payment.')->group(function () {
        Route::controller(PaymentController::class)->group(function () {
            Route::get('/', 'index')->name('Admin.index');
        });
    });

    Route::prefix('Subscribers')->name('Subscribers.')->group(function () {
        Route::controller(SubscribersController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });

    Route::prefix('Contact')->name('Contact.')->group(function () {
        Route::controller(ContactController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{site}/edit', 'edit')->name('edit');
            Route::put('/{site}/update', 'update')->name('update');
        });
    });

    Route::prefix('Inventory')->name('Inventory.')->group(function () {
        Route::controller(InventoryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{Inventory}/edit', 'edit')->name('edit');
            Route::patch('/update-quantity', 'update')->name('update');
        });
    });

    Route::prefix('Features')->name('Features.')->group(function () {
        Route::controller(FeatureController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{feature}/edit', 'edit')->name('edit');
            Route::put('/{feature}/update', 'update')->name('update');
            Route::get('/{feature}/show', 'show')->name('show');
            Route::post('/store', 'store')->name('store');
            Route::delete('/{feature}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Collections')->name('Collections.')->group(function () {
        Route::controller(CollectionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{collection}/edit', 'edit')->name('edit');
            Route::put('/{collection}/update', 'update')->name('update');
            Route::post('/store', 'store')->name('store');
            Route::delete('/{collection}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Sales')->name('Sales.')->group(function () {
        Route::controller(SalesController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{sale}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::get('/getProductPrice/{productId}', 'getProductPrice')->name('getProductPrice');
            Route::get('/createGroup', 'createGroup')->name('createGroup');
            Route::post('/store', 'store')->name('store');
            Route::put('/{sale}/update', 'update')->name('update');
            Route::delete('/{sale}/delete', 'destroy')->name('delete');
        });
        Route::prefix('Promocode')->name('Promocode.')->group(function () {
            Route::controller(PromocodeController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{promotion}/edit', 'edit')->name('edit');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::put('/{promotion}/update', 'update')->name('update');
                Route::delete('/{promotion}/delete', 'destroy')->name('delete');
            });
        });
    });

    Route::prefix('Shipping')->name('Shipping.')->group(function () {
        Route::controller(ShippingController::class)->group(function () {
            Route::get('/Shipping', 'index')->name('index');

            Route::get('/Costs', 'cost')->name('cost.index');
            Route::get('/Estimation-delivery', 'estimations')->name('estimations.index');

            Route::get('/cost/create', 'costCreate')->name('cost.create');
            Route::get('/estimation-delivery/create', 'estimationCreate')->name('estimations.create');

            Route::get('/{shipping}/edit', 'editCost')->name('cost.edit');
            Route::get('/{estimation}/edit/estimation', 'editEstimation')->name('estimations.edit');

            Route::post('/cost/store', 'costStore')->name('cost.store');
            Route::post('/estimation/store', 'estimationStore')->name('estimations.store');

            Route::put('/{shipping}/update', 'costUpdate')->name('cost.update');
            Route::put('/{estimation}/update/estimation', 'estimationUpdate')->name('estimations.update');

            Route::delete('/{shipping}/delete', 'costDelete')->name('cost.delete');
            Route::delete('/{estimation}/delete/estimation', 'estimationDelete')->name('estimations.delete');
        });
    });

    Route::prefix('Orders')->name('Orders.')->group(function () {
        Route::prefix('ShopOrders')->name('ShopOrders.')->group(function () {
            Route::controller(ShopOrdersController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{order}/show', 'show')->name('show');
                Route::delete('/{order}/delete', 'destroy')->name('delete');
            });
        });
        Route::prefix('ToolsOrders')->name('ToolsOrders.')->group(function () {
            Route::controller(ToolsOrdersController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{toolsorders}/show', 'show')->name('show');
                Route::delete('/{toolsorders}/delete', 'destroy')->name('delete');
            });
        });
    });

    Route::get('/get-cities/{country_id}', [ShippingController::class, 'getCities'])->name('get.cities');

});

// require __DIR__.'/auth.php';

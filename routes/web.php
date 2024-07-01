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

// Authentication
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleLoginController;

// User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\BrandsContoller;
use App\Http\Controllers\User\PlatformsController;
use App\Http\Controllers\User\CategoriesController;
use App\Http\Controllers\User\ToolsController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\CartContoller;
use App\Http\Controllers\User\PaymentContoller;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\CheckoutContoller;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ServicesController;
use App\Http\Controllers\User\UserContactController;

// Language
use App\Http\Controllers\LanguageController;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;


// Language
Route::get('language/{locale}', function ($locale) {
    if (array_key_exists($locale, config('app.languages'))) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('language');


Route::middleware('prevent.auth')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'register']);
});

Route::get('/google-login',  [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::post('/google-login', [GoogleLoginController::class, 'handleGoogleLogin'])->name('auth.google.callback');


// Admin Routes
Route::middleware('auth.admin')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::controller(DashboardController::class)->group(function(){
        Route::get('/Dashboard', 'index')->name('Dashboard.index');
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
            Route::get('/{contact}/edit', 'edit')->name('edit');
            Route::put('/{contact}/update', 'update')->name('update');
        });
    });

    Route::prefix('Inventory')->name('Inventory.')->group(function(){
        Route::controller(InventoryController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{Inventory}/edit', 'edit')->name('edit');
            Route::patch('/update-quantity', 'update')->name('update');
        });
    });

    Route::prefix('Features')->name('Features.')->group(function(){
        Route::controller(FeatureController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{feature}/edit', 'edit')->name('edit');
            Route::put('/{feature}/update', 'update')->name('update');
            Route::get('/{feature}/show', 'show')->name('show');
            Route::post('/store', 'store')->name('store');
            Route::delete('/{feature}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Collections')->name('Collections.')->group(function(){
        Route::controller(CollectionController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{collection}/edit', 'edit')->name('edit');
            Route::put('/{collection}/update', 'update')->name('update');
            Route::post('/store', 'store')->name('store');
            Route::delete('/{collection}/delete', 'destroy')->name('delete');
        });
    });

    Route::prefix('Sales')->name('Sales.')->group(function(){
        Route::controller(SalesController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/{sales}/edit', 'edit')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::get('/getProductPrice/{productId}', 'getProductPrice')->name('getProductPrice');
            Route::get('/createGroup', 'createGroup')->name('createGroup');
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
});

// Public Routes

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('index');
});

Route::prefix('Shop')->name('Shop.')->group(function(){
    Route::controller(ShopController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/shop', 'filterIndex')->name('FilterIndex');
        Route::get('/shop/category/{id}', 'categoryFilter')->name('Filter.category');
        Route::get('/shop/subcategory/{id}', 'subcategoryFilter')->name('Filter.subcategory');
        Route::get('/shop/brand/{id}', 'brandFilter')->name('Filter.brand');
        Route::get('/shop/platform/{id}', 'platformFilter')->name('Filter.platform');
    });
});

Route::prefix('Contact')->name('Contact.')->group(function(){
    Route::controller(ContactController::class)->group(function(){
        Route::get('/ContactUs', 'contact')->name('contact');
    });
});

Route::prefix('About')->name('About.')->group(function(){
    Route::controller(AboutController::class)->group(function(){
        Route::get('/', 'index')->name('index');
    });
});

Route::prefix('Tools')->name('Tools.')->group(function(){
    Route::controller(ToolsController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
});

Route::prefix('Product')->name('Product.')->group(function(){
    Route::controller(ProductController::class)->group(function(){
        Route::get('/{product}/Product', 'userShow')->name('show');
    });
});

Route::prefix('Cart')->name('Cart.')->group(function(){
    Route::controller(CartContoller::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/add', 'addToCart')->name('add');
        Route::get('/count', 'getCartCount');
        Route::post('/update', 'updateCart');  //checkout update
        Route::delete('/remove/{productId}','removeFromCart')->name('delete');
    });
});

Route::prefix('Services')->name('Services.')->group(function(){
    Route::controller(ServicesController::class)->group(function(){
        Route::get('/', 'index')->name('index');
    });
});

Route::prefix('Payment')->name('Payment.')->group(function(){
    Route::controller(PaymentContoller::class)->group(function(){
        Route::get('/', 'index')->name('index');
    });
});

Route::prefix('Categories')->name('Categories.')->group(function(){
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/', 'userIndex')->name('index');
        Route::get('/{category}/category', 'show')->name('show');
    });
});

Route::prefix('Brands')->name('Brand.')->group(function(){
    Route::controller(BrandController::class)->group(function(){
        Route::get('/Brands', 'userIndex')->name('index');
        Route::get('/{brand}/brand', 'show')->name('show');
    });
});

Route::prefix('Platforms')->name('Platforms.')->group(function(){
    Route::controller(PlatformController::class)->group(function(){
        Route::get('/', 'userIndex')->name('user.index');
        Route::get('/{platform}/platform', 'show')->name('show');
    });
});

Route::prefix('Checkout')->name('Checkout.')->group(function(){
    Route::controller(CheckoutContoller::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/check-promo-code','checkPromoCode');
        Route::post('/get-delivery-cost', 'getDeliveryCost');
    });
});

// User Routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::controller(UserController::class)->prefix('Profile')->name('Profile.')->group(function(){
        Route::get('/{user}/profile', 'userProfile')->name('profile');
        Route::get('/{user}/edit', 'userProfile')->name('edit');
        Route::put('/{user}/update', 'update')->name('update');
        Route::delete('/{user}/delete', 'destroy')->name('delete');
    });

});

require __DIR__.'/auth.php';
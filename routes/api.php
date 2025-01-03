<?php

// Admin
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BrandsController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\CollectionsController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\FeatureController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\PaymobController;
use App\Http\Controllers\API\PlatformsController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\PromocodesController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\SalesController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\ShopOrdersController;
use App\Http\Controllers\API\GlobalController;
use App\Http\Controllers\API\SubcategoriesController;
use App\Http\Controllers\API\SubscribersController;
use App\Http\Controllers\API\ToolsController;
use App\Http\Controllers\API\ToolsOrderController;
use App\Http\Controllers\API\UserController;
// Authentication
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Authentication

Route::controller(VerifyEmailController::class)->group(function () {
    Route::get('/email/verify/{user}', 'verifyEmailLink')->name('verification.verify');
    Route::post('/verify-code', 'verify');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('logout')->group(function () {
        Route::controller(LogoutController::class)->group(function () {
            Route::post('/current', 'current');
            Route::post('/other', 'other');
            Route::post('/all', 'all');
        });
    });

});

Route::middleware('preventAuthenticated')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'apiLogin']);
    Route::post('/register', [RegisteredUserController::class,       'apiStore']);

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('/forget-password/send-code', 'sendCode');
        Route::post('/forget-password/verify-code', 'verifyCode');
        Route::post('/forget-password/reset', 'resetPassword');
    });

});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::prefix('admins')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{user}/edit', 'edit');
            Route::get('/{user}/profile', 'profile');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::put('/{user}/update', 'update');
            Route::delete('/{user}/delete', 'destroy');
        });
    });

    Route::prefix('products')->group(function () {
        Route::controller(ProductsController::class)->group(function () {
            Route::get('/{product}/edit', 'edit');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::put('/{product}/update', 'update');
            Route::delete('/{product}/delete', 'destroy');
        });
    });

    Route::prefix('brands')->group(function () {
        Route::controller(BrandsController::class)->group(function () {
            Route::get('/{brand}/edit', 'edit');
            Route::post('/store', 'store');
            Route::put('/{brand}/update', 'update');
            Route::delete('/{brand}/delete', 'destroy');
        });
    });

    Route::prefix('category')->group(function () {
        Route::controller(CategoriesController::class)->group(function () {
            Route::get('/admin/categories', 'index');
            Route::get('/{category}/edit', 'edit');
            Route::post('/store', 'store');
            Route::put('/{category}/update', 'update');
            Route::delete('/{category}/delete', 'destroy');
        });
        Route::prefix('subcategory')->group(function () {
            Route::controller(SubcategoriesController::class)->group(function () {
                Route::get('/{subcategory}/edit', 'edit');
                Route::get('/{category}/create', 'create');
                Route::post('/{category}/store', 'store');
                Route::put('/{subcategory}/update', 'update');
                Route::delete('/{subcategory}/delete', 'destroy');
            });
        });
    });

    Route::prefix('platforms')->group(function () {
        Route::controller(PlatformsController::class)->group(function () {
            Route::get('/{platform}/edit', 'edit');
            Route::post('/store', 'store');
            Route::put('/{platform}/update', 'update');
            Route::delete('/{platform}/delete', 'destroy');
        });
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::get('/{user}/profile/admin', 'profile');
        Route::get('/{user}/edit', 'edit');
    });

    Route::prefix('roles')->group(function () {
        Route::controller(RolesController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{role}/edit', 'edit');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::put('/{role}/update', 'update');
            Route::delete('/{role}/delete', 'destroy');
        });
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index');
    });

    Route::prefix('payment')->group(function () {
        Route::controller(PaymentsController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('subscribers')->group(function () {
        Route::controller(SubscribersController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('contact')->group(function () { //Smarven Contact
        Route::controller(ContactController::class)->group(function () {
            Route::get('/{site}/edit', 'edit');
            Route::put('/{site}/update', 'update');
        });
    });

    Route::prefix('inventory')->group(function () {
        Route::controller(InventoryController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{Inventory}/edit', 'edit');
            Route::put('/update-quantity', 'update');
        });
    });

    Route::prefix('features')->group(function () {
        Route::controller(FeatureController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{feature}/edit', 'edit');
            Route::put('/{feature}/update', 'update');
            Route::get('/{feature}/show', 'show');
            Route::post('/store', 'store');
            Route::delete('/{feature}/delete', 'destroy');
        });
    });

    Route::prefix('collections')->group(function () {
        Route::controller(CollectionsController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::get('/{collection}/edit', 'edit');
            Route::put('/{collection}/update', 'update');
            Route::post('/store', 'store');
            Route::delete('/{collection}/delete', 'destroy');
        });
    });

    Route::prefix('sales')->group(function () {
        Route::controller(SalesController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{sales}/edit', 'edit');
            Route::get('/create', 'create');
            Route::get('/getProductPrice/{productId}', 'getProductPrice');
            Route::post('/store', 'store');
            Route::put('/{sales}/update', 'update');
            Route::delete('/{sales}/delete', 'destroy');
        });
        Route::prefix('promocode')->group(function () {
            Route::controller(PromocodesController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{promocode}/edit', 'edit');
                Route::post('/store', 'store');
                Route::put('/{promocode}/update', 'update');
                Route::delete('/{promocode}/delete', 'destroy');
            });
        });
    });

    Route::prefix('orders')->group(function () {
        Route::prefix('shop')->group(function () {
            Route::controller(ShopOrdersController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{shoporder}/show', 'show');
                Route::delete('/{shoporder}/delete', 'destroy');
            });
        });
        Route::prefix('tools')->group(function () {
            Route::controller(ToolsOrderController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{toolsorders}/show', 'show');
                Route::delete('/{toolsorders}/delete', 'destroy');
            });
        });
    });

});

// Public Routes

// Home Page
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

// Contact Us Page
Route::prefix('contact')->group(function () {
    Route::controller(ContactController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/contact-us', 'sendContactUsEmail');
    });
});

// Shop Pages
// 1- Main Shop Page
// 2- Filter Shop Pages
Route::prefix('shop')->group(function () {
    Route::controller(ShopController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/nav-data', 'navData');
        Route::get('/shop', 'filterIndex');
        Route::get('/item', 'getItemByTypeAndId');
        Route::get('/filter-products', 'filterProducts');
    });
});

// Tools Page
Route::prefix('tools')->group(function () {
    Route::controller(ToolsController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/proposal', 'index');
        Route::get('/interior', 'interior');
    });
});

// Product Page
Route::prefix('products')->group(function () {
    Route::controller(ProductsController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/{product}/show', 'show');
        Route::get('/product-card', 'productCards');
    });
});

// Cart Page
Route::prefix('cart')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/add', 'addToCart');
        Route::get('/count', 'getCartCount');
        Route::post('/updateQuantity', 'updateCartQuantity');  //update cart quantity
        Route::post('/update-Installtion', 'updateInstallation');  //update cart installtion price
        Route::delete('/remove/{productId}', 'removeFromCart');
        Route::delete('/clearCart', 'clearCart');
    });
});

// Serives Page
Route::prefix('services')->group(function () {
    Route::controller(ServicesController::class)->group(function () {
        Route::get('/', 'index');
    });
});

// Categories Page
Route::prefix('category')->group(function () {
    Route::controller(CategoriesController::class)->group(function () {
        Route::get('/{category}/show', 'show');
        Route::get('/categories', 'index');
    });
});

// Brands Page
Route::prefix('brands')->group(function () {
    Route::controller(BrandsController::class)->group(function () {
        Route::get('/', 'index');
    });
});

// Platfroms Page
Route::prefix('platforms')->group(function () {
    Route::controller(PlatformsController::class)->group(function () {
        Route::get('/', 'index');
    });
});

// Checkout Page
Route::prefix('checkout')->group(function () {
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/get-delivery-cost', 'getDeliveryCost');
        Route::post('/get-delivery-estimations', 'getDeliveryEstimations');
    });
});

// Subscribers Store
Route::prefix('subscribers')->group(function () {
    Route::controller(SubscribersController::class)->group(function () {
        Route::post('/newSubscriber', 'newSubscriber');
    });
});

// global
Route::controller(GlobalController::class)->group(function () {
    Route::get('/countries', 'countries');
    Route::get('/{countryId}/cities', 'cities');
});

// User Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/profile/user', 'userProfile');
        Route::get('/edit', 'edit');
        Route::get('/profile', 'profile');
        Route::put('/update', 'update');
        Route::delete('/delete', 'destroy');
        Route::post('/deactivate', 'deactivate');
    });

    Route::prefix('checkout')->group(function () {
        Route::controller(CheckoutController::class)->group(function () {
            Route::post('/save-user-data', 'saveUserInfo');
            Route::post('/check-promocode', 'checkPromoCode');

        });
    });

    Route::prefix('payment')->group(function () {
        Route::controller( PaymobController::class)->group(function () {
            Route::post('/create-payment', 'createCheckoutSession');
            Route::post('/cash-payment', 'cashPayment');
            Route::match(['GET', 'POST'], '/paymob/transaction-processed',  'handleTransactionProcessed')->name('paymob.transaction.processed')->withoutMiddleware('auth:sanctum');
        });
    });

});

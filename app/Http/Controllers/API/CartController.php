<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;


class CartController extends Controller
{
    use ApiResponse , HandleImgPath;

    private function getIdentifier(Request $request)
    {
        if (Auth::guard('sanctum')->check()) {
            return ['UserID' => Auth::guard('sanctum')->user()->id];
        } else {
            $sessionId = $request->header('X-Session-ID');

            if ($sessionId) {
                // Ensure Laravel uses the provided session ID
                Session::setId($sessionId);
                Session::start();
            } else {
                $sessionId = Session::getId();
            }

            return ['SessionID' => $sessionId];
        }
    }

    public function index(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $cartItems = ShopOrders::where($identifier)
                            ->with('product.sale')
                            ->get();

        $count = $cartItems->sum('Quantity');

        return $this->getUpdatedCartResponse($request);
    }

    public function addToCart(Request $request)
    {
        $sessionId = $request->header('X-Session-ID');

        if (!$sessionId) {
            return $this->error(['error' => 'Session ID is required'], 'Session ID is required', 400);
        }

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $product = Product::with('sale')->where('ID', $productId)->first();
        if (!$product) {
            return $this->error(['error' => 'Product not found'], 404);
        }

        $price = $product->sale ? $product->sale->PriceAfter : $product->Price;

        // Check if the user is logged in
        $user = Auth::guard('sanctum')->user();
        $userId = $user ? $user->id : null;

        if ($user) {
            // User is logged in
            $userId = $user->id;
            $identifier = ['UserID' => $userId];
        } else {
            // User is not logged in
            $identifier = ['SessionID' => $sessionId];
        }

        $cartItem = ShopOrders::where($identifier)
                              ->where('ProductID', $productId)
                              ->first();

        if ($cartItem) {
            $cartItem->Quantity += $quantity;
            $cartItem->save();
        } else {
            ShopOrders::create([
                'UserID'    => $userId,
                'SessionID' => $sessionId,
                'ProductID' => $productId,
                'Quantity'  => $quantity,
                'Price'     => $price,
                'Status'    => 0,
            ]);
        }

        return $this->getUpdatedCartResponse($request);
    }

    public function updateCartQuantity(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $sessionId = $request->header('X-Session-ID');

        if (!$sessionId) {
            return $this->error(['error' => 'Session ID is required'], 'Session ID is required', 400);
        }

        $productId = $request->product_id;
        $quantity = $request->quantity;
        $installationCost = $request->installation_cost ?? 0;

        $cartItem = ShopOrders::where($identifier)
                            ->where('ProductID', $productId)
                            ->first();

        if (!$cartItem) {
            return $this->error(['error' => 'Cart item not found'], 'Cart item not found', 404);
        }

        if ($quantity < 1) {
            return $this->error(['error' => 'Quantity must be at least 1'], 'Invalid quantity', 400);
        }


        $total = $quantity * $cartItem->Price + $installationCost;
        ShopOrders::where('ProductID', $productId)
              ->where($identifier)
              ->where('SessionID', $sessionId)
              ->update([
                    'Quantity'         => $quantity,
                    'Total'            => $total,
                ]);

        return $this->getUpdatedCartResponse($request);
    }

    public function toggleInstallation(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $sessionId = $request->header('X-Session-ID');

        if (!$sessionId) {
            return $this->error(['error' => 'Session ID is required'], 'Session ID is required', 400);
        }

        $productId = $request->product_id;
        $withInstallation = $request->installation_cost ?? 0;

        // Check if the user is logged in
        $user = Auth::guard('sanctum')->user();
        $userId = $user ? $user->id : null;

        if ($user) {
            // User is logged in
            $userId = $user->id;
            $identifier = ['UserID' => $userId];
        } else {
            // User is not logged in
            $identifier = ['SessionID' => $sessionId];
        }

        $cartItem = ShopOrders::where($identifier)
                            ->where('ProductID', $productId)
                            ->first();
        if (!$cartItem) {
            return $this->error(['error' => 'Cart item not found'], 'Cart item not found', 404);
        }

        $total = $cartItem->Quantity * $cartItem->Price + $withInstallation;
        ShopOrders::where('ProductID', $productId)
            ->where($identifier)
            ->where('SessionID', $sessionId)
            ->update([
                    'WithInstallation' => $withInstallation,
                    'Total'            => $total,
                ]);

        return $this->getUpdatedCartResponse($request);
    }

    // Checkout Update
    public function updateCart(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $cartData   = $request->input('cart');
        $totalPrice = $request->input('total_price');
        $savedAmount= $request->input('saved_amount');
        $finalTotal = $request->input('final_total');

        foreach ($cartData as $item) {
            ShopOrders::updateOrCreate(
                array_merge($identifier, ['ProductID' => $item['product_id']]),
                [
                    'Quantity'         => $item['quantity'],
                    'WithInstallation' => $item['installation_cost'],
                    'Total'            => $item['subtotal'],
                    'Status'           => 2, //User Just CheckedOut and not paid yet
                ]
            );
        }

        return $this->success('Cart updated successfully');
    }


    public function removeFromCart(Request $request, $productId)
    {
        $identifier = $this->getIdentifier($request);

        ShopOrders::where($identifier)
                ->where('ProductID', $productId)
                ->delete();

        return $this->getUpdatedCartResponse($request);
    }

    public function getCartCount(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $count = ShopOrders::where($identifier)->sum('Quantity');
        return response()->json(['count' => $count]);
    }

    public function clearCart(Request $request)
    {
        $identifier = $this->getIdentifier($request);

        ShopOrders::where($identifier)->delete();

        return $this->getUpdatedCartResponse($request);
    }

    private function getUpdatedCartResponse(Request $request)
    {
        $identifier = $this->getIdentifier($request);

        $cartItems = ShopOrders::where($identifier)
                    ->with(['product.sale'])
                    ->get();

        $total = $cartItems->sum(function($item) {
            // Add the quantity * price and the installation cost (WithInstallation) if available
            return ($item->Quantity * $item->Price) + ($item->WithInstallation ?? 0);
        });

        $count = $cartItems->sum('Quantity');

        $products = Product::with(['brand', 'platforms' , 'sale'])->get();

        $totalSaved = $cartItems->sum(function ($item) {
            return $item->product->sale ? ($item->product->Price - $item->product->sale->PriceAfter) * $item->Quantity : 0;
        });

        $data = [
            'count'    => $count,
            'total'    => $total,
            'totalSaved' => $totalSaved,
            'cartItems'=> $this->transformImagePaths($cartItems),
            'products' => $this->transformImagePaths($products),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'data'    => $data,
        ]);
    }
}

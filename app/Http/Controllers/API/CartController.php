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

            return ['CartID' => $sessionId];
        }
    }

    public function index(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $cartItems = ShopOrders::where($identifier)
                            ->with('product')
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
            $identifier = ['CartID' => $sessionId];
        }
    // dd( $identifier);
        $cartItem = ShopOrders::where($identifier)
                              ->where('ProductID', $productId)
                              ->first();
    
        if ($cartItem) {
            $cartItem->Quantity += $quantity;
            $cartItem->save();
        } else {
            ShopOrders::create([
                'UserID'    => $userId,
                'CartID'    => $sessionId,
                'ProductID' => $productId,
                'Quantity'  => $quantity,
                'Price'     => $price,
                'Status'    => 0,
            ]);
        }
    
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
                    ->with('product')
                    ->get();

        $total = $cartItems->sum(function($item) {
            return $item->Quantity * $item->Price;
        });

        $count = $cartItems->sum('Quantity');

        $products = Product::with(['brand', 'platforms'])->get();

        $data = [
            'count'    => $count,
            'total'    => $total,
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
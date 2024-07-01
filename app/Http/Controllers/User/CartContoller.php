<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartContoller extends Controller
{
    private function getIdentifier()
    {
        if (Auth::guard('web')->check()) {
            return ['UserID'    => Auth::guard('web')->user()->id];
        } else {
            return ['SessionID' => Session::getId()];
        }
    }

    public function index()
    {
        $identifier = $this->getIdentifier();
        $cartItems = ShopOrders::where($identifier)
                    ->with('product') 
                    ->get();

        $total = 0;

        $products = Product::all();

        $count = ShopOrders::where($identifier)->sum('Quantity');
        return view('User.Cart.cart' , compact('count' , 'cartItems' , 'products'));
    }

    public function addToCart(Request $request)
    {
        $identifier = $this->getIdentifier();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $price = $request->price;
        $installationCost = $request->installation_cost ?? 0;
        $cartItem = ShopOrders::where($identifier)
                    ->where('ProductID', $productId)
                    ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            ShopOrders::create(array_merge($identifier, [
                'ProductID'        => $productId,
                'CartID'           => Session::getId(),
                'Quantity'         => $quantity,
                'Price'            => $price,
                'Status'           => 0,  //User just insrted data into the cart
            ]));
        }

        return response()->json(['success' => 'Product added to cart']);
    }

    // Checkout Update
    public function updateCart(Request $request)
    {
        $identifier = $this->getIdentifier();
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

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function removeFromCart($productId)
    {
        $identifier = $this->getIdentifier();
        ShopOrders::where($identifier)->where('ProductID', $productId)->delete();
        return response()->json(['success' => 'Product removed from cart']);
    }

    public function getCartCount()
    {
        $identifier = $this->getIdentifier();
        $count = ShopOrders::where($identifier)->sum('Quantity');
        return response()->json(['count' => $count]);
    }

    public function clearCart()
    {
        $identifier = $this->getIdentifier();

        ShopOrders::where($identifier)->delete();

        return response()->json(['success' => 'Cart cleared']);
    }

}
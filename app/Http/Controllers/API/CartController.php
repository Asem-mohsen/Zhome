<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ Order , Product , OrderInstallation};
use Illuminate\Support\Facades\{ Auth , Session};
use App\Traits\ApiResponse;
use App\Enums\OrderStatusEnum;
use App\Http\Resources\ProductCardResource;

class CartController extends Controller
{
    use ApiResponse;

    protected $pending = OrderStatusEnum::PENDING->value;

    private function getIdentifier(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            return ['user_id' => $user->id];
        }

        $sessionId = $request->header('X-Session-ID') ?: Session::getId();
        return ['session_id' => $sessionId];
    }

    public function index(Request $request) // cart page
    {
        $identifier = $this->getIdentifier($request);

        $cartItems = Order::where($identifier)->where('status', $this->pending)->with([ 'product.brand', 'product.platforms', 'product.translations'])->get();

        $count = $cartItems->sum('quantity');

        return $this->getUpdatedCartResponse($cartItems);
    }

    public function addToCart(Request $request)
    {
        $sessionId = $request->header('X-Session-ID') ?: Session::getId();
        $productId = $request->product_id;
        $quantity  = $request->input('quantity', 1);
        $installationCost = $request->input('installation_cost', 0);
        $withInstallation = $request->input('with_installation', false);

        $product = Product::with('sale')->find($productId);
        if (!$product) {
            return $this->error(['error' => 'Product not found'], 'Product not found', 404);
        }

        $is_sale = $product->isOnSale();

        $price = $product->getCurrentPrice();

        $identifier = $this->getIdentifier($request);

        $cartItem = Order::where($identifier)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            $cartItem->update([
                'total_amount' => $cartItem->quantity * $price + ($withInstallation ? $installationCost : 0),
                'with_installation' => $withInstallation,
            ]);
        } else {
            $cartItem = Order::create([
                'user_id'         => $identifier['user_id'] ?? null,
                'session_id'      => $identifier['session_id'] ?? $sessionId,
                'product_id'      => $productId,
                'quantity'        => $quantity,
                'price'           => $price,
                'is_on_sale'      => $is_sale,
                'total_amount'    => $quantity * $price + ($withInstallation ? $installationCost : 0),
                'status'          => $this->pending,
                'with_installation' => $withInstallation,
            ]);
        }

        $this->updateInstallation($cartItem, $withInstallation, $installationCost);

        return $this->getUpdatedCartResponse(Order::where($identifier)->get());
    }

    public function updateCartQuantity(Request $request)
    {
        $identifier = $this->getIdentifier($request);
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $installationCost = $request->installation_cost ?? 0;
        $withInstallation = $request->input('with_installation', false);

        $cartItem = Order::where($identifier)->where('product_id', $productId)->first();
        if (!$cartItem) {
            return $this->error(['error' => 'Cart item not found'], 'Cart item not found', 404);
        }

        if ($quantity < 1) {
            return $this->error(['error' => 'Quantity must be at least 1'], 'Invalid quantity', 400);
        }

        $cartItem->update([
            'quantity'       => $quantity,
            'total_amount'   => $quantity * $cartItem->price + ($withInstallation ? $installationCost : 0),
            'with_installation' => $withInstallation,
        ]);

        $this->updateInstallation($cartItem, $withInstallation, $installationCost);

        return $this->getUpdatedCartResponse(Order::where($identifier)->get());
    }

    private function updateInstallation(Order $cartItem, bool $withInstallation, int $installationCost)
    {
        if ($withInstallation) {
            OrderInstallation::updateOrCreate(
                ['order_id' => $cartItem->id],
                ['installation_cost' => $installationCost]
            );
        } else {
            OrderInstallation::where('order_id', $cartItem->id)->delete();
        }
    }

    // Checkout Update
    // public function updateCart(Request $request)
    // {
    //     $identifier = $this->getIdentifier($request);
    //     $cartData   = $request->input('cart');
    //     $totalPrice = $request->input('total_price');
    //     $savedAmount= $request->input('saved_amount');
    //     $finalTotal = $request->input('final_total');

    //     foreach ($cartData as $item) {
    //         Order::updateOrCreate(
    //             array_merge($identifier, ['ProductID' => $item['product_id']]),
    //             [
    //                 'Quantity'         => $item['quantity'],
    //                 'WithInstallation' => $item['installation_cost'],
    //                 'Total'            => $item['subtotal'],
    //                 'Status'           => 2, //User Just CheckedOut and not paid yet
    //             ]
    //         );
    //     }

    //     return $this->success('Cart updated successfully');
    // }

    public function removeFromCart(Request $request, $productId)
    {
        $identifier = $this->getIdentifier($request);

        $cartItem = Order::where($identifier)
                        ->where('product_id', $productId)
                        ->where('status', $this->pending)
                        ->first();

        $cartItem->delete();

        return $this->getUpdatedCartResponse(Order::where($identifier)->get());
    }

    public function getCartCount(Request $request)
    {
        $identifier = $this->getIdentifier($request);

        $count = Order::where($identifier)->where('status' , $this->pending)->count();

        return $this->data(['count' => $count] , 'data retrived successfully');
    }

    public function clearCart(Request $request)
    {
        $identifier = $this->getIdentifier($request);

        Order::where($identifier)
            ->where('status', $this->pending)
            ->delete();

        return $this->getUpdatedCartResponse(Order::where($identifier)->get());
    }

    private function getUpdatedCartResponse($cartItems)
    {
        $count = $cartItems->sum('quantity');
        $total = $cartItems->sum('total_amount');

        $totalSaved = $cartItems->reduce(function ($carry, $item) {
            $savingsPerItem = 0;

            if ($item->product && $item->product->isOnSale()) {
                $originalPrice = $item->product->price;
                $salePrice = $item->product->getCurrentPrice();
                $savingsPerItem = ($originalPrice - $salePrice) * $item->quantity;
            }

            return $carry + $savingsPerItem;
        }, 0);

        return response()->json([
            'items' => $cartItems,
            'count' => $count,
            'total_amount' => $total,
            'total_saved' => $totalSaved,
        ]);
    }
}

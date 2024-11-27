<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderInstallation;
use App\Models\Product;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    use ApiResponse;

    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $cartItems = $this->cartService->getCartItems($identifier);
        
        return $this->data($this->cartService->getCartSummary($cartItems) , 'cart data retrieved successfully');
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'installation_cost' => 'nullable|numeric|min:0',
            'with_installation' => 'nullable|boolean',
        ]);

        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $cartItem = $this->cartService->addToCart(
            $identifier,
            $validated['product_id'],
            $validated['quantity'] ?? 1,
            $validated['installation_cost'] ?? 0,
            $validated['with_installation'] ?? false
        );

        $cartItems = $this->cartService->getCartItems($identifier);
        return $this->data($this->cartService->getCartSummary($cartItems) , 'item added successfully');
    }

    public function updateCartQuantity(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:orders,product_id',
            'quantity' => 'required|integer|min:1',
            'installation_cost' => 'nullable|numeric|min:0',
            'with_installation' => 'nullable|boolean',
        ]);

        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $cartItem = Order::where($identifier)
            ->where('product_id', $validated['product_id'])
            ->firstOrFail();

        $this->cartService->updateCartQuantity($cartItem, $validated['quantity'], $validated['with_installation'] ?? false, $validated['installation_cost'] ?? 0);

        $cartItems = $this->cartService->getCartItems($identifier);
        return $this->data($this->cartService->getCartSummary($cartItems) , 'cart data updated successfully');
    }

    public function updateInstallation(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:orders,product_id',
            'installation_cost' => 'required',
        ]);

        $user = Auth::guard('sanctum')->user();

        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $cartItem = Order::where($identifier)
                    ->where('product_id', $request->product_id)
                    ->first();

        if (!$cartItem) {
            return $this->error(['message' => 'Cart item not found.'],'Cart item not found.' ,404);
        }

        $withInstallation = $request->installation_cost > 0;

        if ($withInstallation) {

            $cartItem->update(['with_installation' => 1]);

            OrderInstallation::updateOrCreate(
                ['order_id' => $cartItem->id],
                ['installation_cost' => $request->installation_cost]
            );
        } else {
            OrderInstallation::where('order_id', $cartItem->id)->delete();
            $cartItem->update(['with_installation' => 0]);
        }

        $cartItems = $this->cartService->getCartItems($identifier);

        return $this->data($this->cartService->getUpdatedCartResponse($cartItems),'Data retrieved successfully');
    }

    public function removeFromCart(Request $request, $productId)
    {
        $user = Auth::guard('sanctum')->user();

        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $this->cartService->removeCartItem($identifier, $productId);

        $cartItems = $this->cartService->getCartItems($identifier);

        return $this->data($this->cartService->getUpdatedCartResponse($cartItems),'cart item removed successfully');
    }

    public function getCartCount(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $count = $this->cartService->getCartCount($identifier);

        return $this->data(['count' => $count],'Data retrieved successfully');
    }

    public function clearCart(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $this->cartService->clearCart($identifier);

        $cartItems = $this->cartService->getCartItems($identifier);

        return $this->data($this->cartService->getUpdatedCartResponse($cartItems),'cart data cleared successfully');
    }

}

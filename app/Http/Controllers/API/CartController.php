<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Cart\{AddToCartRequest,UpdateCartInstallationRequest,UpdateCartRequest};
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ApiResponse;

    public function __construct(private CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $cartData = $this->cartService->getCart($identifier);

        return successResponse($cartData, 'Cart data retrieved successfully');
    }

    public function addToCart(AddToCartRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $cartData = $this->cartService->addToCart($identifier, $validated);

        return successResponse($cartData, 'Item added successfully');
    }

    public function updateCartQuantity(UpdateCartRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $cartData = $this->cartService->updateCartQuantity($identifier, $validated);

        return successResponse($cartData, 'Cart data updated successfully');
    }

    public function updateInstallation(UpdateCartInstallationRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $cartData = $this->cartService->updateInstallation($identifier, $validated);

        return successResponse($cartData, 'Installation data updated successfully');
    }

    public function removeFromCart(Request $request, $productId)
    {
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $cartData = $this->cartService->removeFromCart($identifier, $productId);

        return successResponse($cartData, 'Cart item removed successfully');
    }

    public function getCartCount(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $count = $this->cartService->getCartCount($identifier);

        return successResponse(['count' => $count], 'Cart count retrieved successfully');
    }

    public function clearCart(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID'));

        $cartData = $this->cartService->clearCart($identifier);

        return successResponse($cartData, 'Cart cleared successfully');
    }

}

<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderInstallation;
use App\Models\Product;
use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    private $pendingStatus;

    public function __construct()
    {
        $this->pendingStatus = OrderStatusEnum::PENDING->value;
    }

    public function getCartIdentifier($user, $sessionId): array
    {
        if ($user) {
            return ['user_id' => $user->id];
        }
    
        $sessionId = $sessionId ?: Session::getId();
    
        if (!$sessionId) {
            throw new \Exception('Session ID could not be determined.');
        }
    
        return ['session_id' => $sessionId];
    }

    public function getCartItems(array $identifier): Collection
    {
        return Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->with(['product.translations', 'product.brand', 'product.platforms'])
            ->get();
    }

    public function addToCart(array $identifier, $productId, $quantity, $installationCost, $withInstallation): Order
    {
        $product = Product::find($productId);

        $cartItem = Order::where($identifier)
            ->where('product_id', $productId)
            ->where('status', $this->pendingStatus)
            ->first();

        $price = $product->getCurrentPrice();
        $isSale = $product->isOnSale();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cartItem = Order::create([
                'user_id' => $identifier['user_id'] ?? null,
                'session_id' => $identifier['session_id'] ?? Session::getId(),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'with_installation' => $withInstallation,
                'is_on_sale' => $isSale,
                'total_amount' => $quantity * $price,
                'status' => $this->pendingStatus,
            ]);
        }

        $this->updateInstallation($cartItem, $withInstallation, $installationCost);

        return $cartItem;
    }

    public function updateCartQuantity(Order $cartItem, int $quantity, bool $withInstallation, int $installationCost)
    {
        $cartItem->update([
            'quantity' => $quantity,
            'total_amount' => $quantity * $cartItem->price + ($withInstallation ? $installationCost : 0),
            'with_installation' => $withInstallation,
        ]);

        $this->updateInstallation($cartItem, $withInstallation, $installationCost);
    }

    public function updateInstallation(Order $cartItem, bool $withInstallation, int $installationCost)
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

    public function getCartSummary(Collection $cartItems): array
    {
        $totalAmount = $cartItems->sum('total_amount');
        $totalSaved = $cartItems->reduce(function ($carry, $item) {
            if ($item->product && $item->product->isOnSale()) {
                $originalPrice = $item->product->price;
                $salePrice = $item->product->getCurrentPrice();
                return $carry + (($originalPrice - $salePrice) * $item->quantity);
            }
            return $carry;
        }, 0);

        return [
            'items' => $cartItems,
            'count' => $cartItems->sum('quantity'),
            'total_amount' => $totalAmount,
            'total_saved' => $totalSaved,
        ];
    }

    public function removeCartItem($identifier, $productId)
    {
        $cartItem = Order::where($identifier)
            ->where('product_id', $productId)
            ->where('status', $this->pendingStatus)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }
    }

    public function clearCart($identifier)
    {
        Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->delete();
    }

    public function getCartCount($identifier)
    {
        return Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->count();
    }

    public function getUpdatedCartResponse($cartItems)
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

        return [
            'items' => $cartItems,
            'count' => $count,
            'total_amount' => $total,
            'total_saved' => $totalSaved,
        ];
    }
}

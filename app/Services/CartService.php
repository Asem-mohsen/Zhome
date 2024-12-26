<?php

namespace App\Services;

use App\Models\{Order,Product};
use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\Session;

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

    public function getCart(array $identifier): ?array
    {
        $order = Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->with(['products.product.translations'])
            ->first();

        return $this->formatCartData($order);
    }

    public function addToCart(array $identifier, array $data): array
    {
        $order = Order::firstOrCreate(
            array_merge($identifier, ['status' => $this->pendingStatus]),
            ['total_amount' => 0]
        );
    
        $product = Product::findOrFail($data['product_id']);
        $quantity = $data['quantity'] ?? 1;
    
        $orderProduct = $order->products()->where('product_id', $data['product_id'])->first();
    
        if ($orderProduct) {
            $orderProduct->quantity += $quantity;
            $orderProduct->with_installation = $data['with_installation'] ?? $orderProduct->with_installation;
            $orderProduct->save();
        } else {
            $order->products()->create([
                'product_id' => $data['product_id'],
                'quantity' => $quantity,
                'with_installation' => $data['with_installation'] ?? false,
            ]);
        }
    
        $this->updateOrderTotal($order);
    
        return $this->formatCartData($order);
    }

    public function updateCartQuantity(array $identifier, array $data): array
    {
        $order = Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->firstOrFail();

        $orderProduct = $order->products()->where('product_id', $data['product_id'])->firstOrFail();

        $orderProduct->update([
            'quantity' => $data['quantity'],
        ]);

        $this->updateOrderTotal($order);

        return $this->formatCartData($order);
    }

    public function updateInstallation(array $identifier, array $data): array
    {
        $order = Order::where($identifier)
        ->where('status', $this->pendingStatus)
        ->firstOrFail();

        $orderProduct = $order->products()->where('product_id', $data['product_id'])->firstOrFail();

        $orderProduct->update([
            'with_installation' => $data['with_installation'],
        ]);

        $this->updateOrderTotal($order);

        return $this->formatCartData($order);
    }

    public function removeFromCart(array $identifier, $productId): array
    {
        $order = Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->firstOrFail();

        $order->products()->where('product_id', $productId)->delete();

        $this->updateOrderTotal($order);

        return $this->formatCartData($order);
    }

    public function clearCart(array $identifier): array
    {
        $order = Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->first();

        if ($order) {
            $order->products()->delete();
            $order->delete();
        }

        return $this->formatCartData(null);
    }

    public function getCartCount(array $identifier): int
    {
        $order = Order::where($identifier)
            ->where('status', $this->pendingStatus)
            ->with('products')
            ->first();

        if (!$order) {
            return 0;
        }

        return $order->products->count();
    }

    private function updateOrderTotal(Order $order): void
    {
        $totalAmount = $order->products->sum(function ($orderProduct) {
            $basePrice = $orderProduct->quantity * $orderProduct->product->getCurrentPrice();

            $installationCost = $orderProduct->with_installation
                ? $orderProduct->product->installation_cost
                : 0;

            return $basePrice + $installationCost;
        });

        $order->update(['total_amount' => $totalAmount]);
    }

    private function formatCartData(?Order $order): ?array
    {
        if (!$order) {
            return ['order' => null];
        }

        $totalSaved = 0;

        $orderData = [
            'id' => $order->id,
            'total_amount' => $order->total_amount,
            'products' => $order->products->map(function ($orderProduct) use (&$totalSaved) {
                $product = $orderProduct->product;
                $installationCost = $orderProduct->with_installation ? $product->installation_cost : 0;

                $isOnSale = $product->isOnSale();
                $currentPrice = $product->getCurrentPrice();
                $originalPrice = $product->price;
    
                // Calculate savings for this product
                if ($isOnSale) {
                    $savedAmount = ($originalPrice - $currentPrice) * $orderProduct->quantity;
                    $totalSaved += $savedAmount;
                }

                return [
                    'product_id' => $product->id,
                    'product_quantity' => $product->quantity,
                    'image_url' => $product->getFirstMediaUrl('product_featured_image'),
                    'installation_cost' => $product->installation_cost,
                    'translations' => $product->translations,
                    'quantity' => $orderProduct->quantity,
                    'with_installation' => $orderProduct->with_installation,
                    'price' => $product->getCurrentPrice(),
                    'old_price' => $isOnSale ? $product->price : null,
                    'total' => $orderProduct->quantity * $product->getCurrentPrice() + $installationCost,
                ];
            }),
            'total_saved' => $totalSaved,

        ];

        return ['order' => $orderData];
    }
}

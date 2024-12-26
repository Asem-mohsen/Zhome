<?php

namespace App\Services;

use App\Models\{Order, Product, Promotion, Shipping, UserAddress, UserPhone};
use App\Enums\OrderStatusEnum;
use App\Http\Requests\API\Checkout\{CheckPromocodeRequest, GetDeliveryCostRequest, GetDeliveryEstimationRequest , SaveUserInfoCheckout };
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckoutService
{protected $pending;
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->pending = OrderStatusEnum::PENDING->value;
        $this->cartService = $cartService;
    }

    private function getIdentifier(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            return ['user_id' => $user->id];
        }

        $sessionId = $request->header('X-Session-ID') ?: session()->getId();

        return ['session_id' => $sessionId];
    }

    public function getCheckoutData(Request $request): array
    {
        $identifier = $this->getIdentifier($request);
        $order = Order::where($identifier)
            ->where('status', $this->pending)
            ->with(['products.product.translations'])
            ->first();

        $user = null;
        if (Auth::guard('sanctum')->check()) {
            $authUser = Auth::guard('sanctum')->user()->load(['address', 'phones']);
            $user = $this->formatUserData($authUser);
        }

        return [
            'order' => $order,
            'user' => $user,
        ];
    }

    public function saveUserInformation(SaveUserInfoCheckout $request): void
    {
        $user = Auth::guard('sanctum')->user();
        $data = $this->formatUserInput($request);

        if ($user) {
            foreach ($data['phones'] as $phone) {
                UserPhone::updateOrCreate(
                    ['user_id' => $user->id, 'phone' => $phone],
                    ['phone' => $phone]
                );
            }

            UserAddress::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'city_id'        => $data['city_id'],
                    'country_id'     => $data['country_id'],
                    'street_address' => $data['street_address'],
                    'floor'          => $data['floor'],
                    'apartment'      => $data['apartment'],
                    'building'       => $data['building'],
                ]
            );

            $user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
            ]);
        }
    }

    public function validatePromoCode(CheckPromocodeRequest $request): array
    {
        $validated = $request->validated();
        
        $totalPrice = $validated['total_amount'];

        $promotion = Promotion::where('code', $validated['promotion'])
            ->where('status', 'active')
            ->where('valid_until', '>', Carbon::now())
            ->first();

        if ($promotion) {
            $discount = $totalPrice * ($promotion->discount_amount / 100);
            $total = $totalPrice - $discount;

            return [
                'success' => true,
                'data' => ['discount' => $discount, 'total' => $total],
            ];
        }

        return ['success' => false];
    }

    public function calculateDeliveryCost(GetDeliveryCostRequest $request): array
    {
        $validated = $request->validated();
        $cityData = Shipping::where('city_id', $validated['city_id'])->first();
        $deliveryCost = $cityData ? $cityData->shipping_fee : 0;

        $identifier = $this->cartService->getCartIdentifier(Auth::guard('sanctum')->user(), $request->header('X-Session-ID'));
        $cartItems = $this->cartService->getCart($identifier);

        if (!$cartItems) {
            throw new \RuntimeException('Cart data could not be found.');
        }

        $updatedTotal = $cartItems['order']['total_amount'] + $deliveryCost;

        return [
            'deliveryCost' => $deliveryCost,
            'cartTotal' => $cartItems['order']['total_amount'],
            'updatedTotal' => $updatedTotal,
        ];
    }

    public function fetchDeliveryEstimations(GetDeliveryEstimationRequest $request): array
    {
        $validated = $request->validated();

        $identifier = $this->cartService->getCartIdentifier(Auth::guard('sanctum')->user(), $request->header('X-Session-ID'));
        $cartItems = $this->cartService->getCart($identifier);

        if (!$cartItems) {
            throw new \RuntimeException('Cart data could not be found.');
        }

        $products = Product::whereIn('id', $cartItems['products']->pluck('product_id'))
            ->with(['deliveryEstimations' => function ($query) use ($request) {
                $query->where('country_id', $request->country_id)
                    ->where('city_id', $request->city_id);
            }])
            ->get();

        return $products->map(function ($product) {
            $estimation = $product->deliveryEstimations->first();
            if ($estimation) {
                return [
                    'product_id' => $product->id,
                    'estimation_details' => $estimation->estimation_details,
                    'estimated_delivery_date' => $estimation->estimated_delivery_date,
                ];
            }

            return [
                'code' => 404,
                'message' => 'No estimations available for this product.',
            ];
        })->toArray();
    }

    private function formatUserData($authUser): array
    {
        $firstPhone = $authUser->phones->first()?->phone ?? null;
        $fullName = $authUser->name ?? '';
        $nameParts = explode(' ', trim($fullName), 2);

        return [
            'name' => $fullName,
            'first_name' => $nameParts[0] ?? '',
            'last_name' => $nameParts[1] ?? '',
            'email' => $authUser->email,
            'phone' => $firstPhone,
            'address' => $authUser->address->street_address ?? '',
            'city' => $authUser->address->city_id ?? '',
            'country' => $authUser->address->country_id ?? '',
            'floor' => $authUser->address->floor ?? '',
            'building' => $authUser->address->building ?? '',
            'apartment' => $authUser->address->apartment ?? '',
        ];
    }

    private function formatUserInput(SaveUserInfoCheckout $request): array
    {
        $cityData = $request->input('city_id');
        if (is_string($cityData)) {
            $cityData = json_decode($cityData, true);
        }

        $cityId = is_array($cityData) && isset($cityData['id']) ? $cityData['id'] : $cityData;

        return [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phones' => $request->input('phone'),
            'city_id' => $cityId,
            'country_id' => $request->input('country_id'),
            'street_address' => $request->input('street_address'),
            'floor' => $request->input('floor'),
            'apartment' => $request->input('apartment'),
            'building' => $request->input('building'),
        ];
    }
}
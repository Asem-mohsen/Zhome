<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SaveUserInfoCheckout;
use App\Models\{Order , Product, Promotion , Shipping , UserAddress ,UserPhone};
use App\Services\CartService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth ,Session };

class CheckoutController extends Controller
{
    use ApiResponse;

    protected $pending = OrderStatusEnum::PENDING->value;

    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    private function getIdentifier(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            return ['user_id' => $user->id];
        }

        $sessionId = $request->header('X-Session-ID') ?: Session::getId();

        return ['session_id' => $sessionId];
    }

    public function index(Request $request)
    {
        $identifier = $this->getIdentifier($request);

        $orders = Order::where($identifier)->where('status', $this->pending)->with(['product.brand', 'product.translations', 'product.platforms'])->get();

        $total = $orders->sum(function ($order) {
            return ($order->quantity * $order->price) +
                ($order->with_installation ?  $order->product->installation_cost : 0);
        });

        $user = null;

        if (Auth::guard('sanctum')->check()) {
            $authUser = Auth::guard('sanctum')->user()->load(['address', 'phones']);

            $firstPhone = $authUser->phones->first()?->phone ?? null;
            $fullName = $authUser->name ?? '';
            $nameParts = explode(' ', trim($fullName), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? ''; 
            $user = [
                'name' => $fullName ,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $authUser->email,
                'phone' => $firstPhone ,
                'address' => $authUser->address->street_address,
                'city' => $authUser->address->city_id,
                'country' => $authUser->address->country_id,
                'floor' => $authUser->address->floor,
                'building' => $authUser->address->building,
                'apartment' => $authUser->address->apartment,
            ];
        }

        $data = [
            'total' => $total,
            'orders' => $orders,
            'user' => $user,
        ];

        return $this->data($data, 'Checkout data retrieved successfully');
    }

    public function saveUserInfo(SaveUserInfoCheckout $request)
    {
        $user = Auth::guard('sanctum')->user();
        $cityData = $request->input('city');
        if (is_string($cityData)) {
            $cityData = json_decode($cityData, true);
        }
    
        $cityId = is_array($cityData) && isset($cityData['id']) ? $cityData['id'] : $cityData;

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phones' => $request->input('phone'),
            'city' => $cityId,
            'country' => $request->input('country'),
            'street_address' => $request->input('street_address'),
            'floor' => $request->input('floor'),
            'apartment' => $request->input('apartment'),
            'building' => $request->input('building'),
        ];

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
                    'city_id' => $data['city'],
                    'country_id' => $data['country'],
                    'street_address' => $data['street_address'],
                    'floor' => $data['floor'],
                    'apartment' => $data['apartment'],
                    'building' => $data['building'],
                ]
            );

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        }

        return $this->success('User data updated successfully', 200);
    }

    public function checkPromoCode(Request $request)
    {
        $request->validate([
            'promotion' => 'required|string',
            'total_amount' => 'required|numeric',
        ]);

        $promotion = $request->promotion;
        $totalPrice = $request->total_amount;

        $promotionData = Promotion::where('code', $promotion)
            ->where('status', 'active')
            ->where('valid_until', '>', Carbon::now())
            ->first();

        if ($promotionData) {
            $discount = $totalPrice * ($promotionData->discount_amount / 100);
            $total = $totalPrice - $discount;

            return $this->data(['discount' => $discount, 'total' => $total], 'Disscount Applied Successfully', 200);
        } else {
            return $this->error(['message' => 'Invalid Promocode'], 'Invalid Promocode', 404);
        }
    }

    public function getDeliveryCost(Request $request)
    {
        $request->validate([
            'cityId' => 'required|exists:cities,id',
        ]);

        $cityData = Shipping::where('city_id', $request->cityId)->first();
        $deliveryCost = $cityData ? $cityData->shipping_fee : 0;

        $user = Auth::guard('sanctum')->user();

        $identifier =  $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $cartItems =  $this->cartService->getCartItems($identifier);

        $cartTotal = $cartItems->sum(function ($order) {
            return ($order->quantity * $order->price) +
                ($order->with_installation ? $order->product->installation_cost : 0);
        });

        $updatedTotal = $cartTotal + $deliveryCost;

        return response()->json([
            'deliveryCost' => $deliveryCost,
            'cartTotal' => $cartTotal,
            'updatedTotal' => $updatedTotal,
        ]);
    }

    public function getDeliveryEstimations(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        $user = Auth::guard('sanctum')->user();

        $identifier = $this->cartService->getCartIdentifier($user, $request->header('X-Session-ID') ?: Session::getId());

        $cartItems = $this->cartService->getCartItems($identifier);

        $products = Product::whereIn('id', $cartItems->pluck('product_id'))
            ->with(['deliveryEstimations' => function ($query) use ($request) {
                $query->where('country_id', $request->country_id)
                    ->where('city_id', $request->city_id);
            }])
            ->get();


            $response = $products->map(function ($product) {
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
            });

        return $this->data(['data' => $response],'estimation for the products found' ,200);
    }
}

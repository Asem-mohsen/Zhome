<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SaveUserInfoCheckout;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Shipping;
use App\Models\UserAddress;
use App\Models\UserPhone;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
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

    public function index(Request $request)
    {
        $identifier = $this->getIdentifier($request);

        $orders = Order::where($identifier)->where('status', $this->pending)->with(['product.brand', 'product.translations', 'product.platforms'])->get();

        $total = $orders->sum(function ($order) {
            return ($order->quantity * $order->price) +
                ($order->with_installation ? $order->product->InstallationCost : 0);
        });

        $user = null;

        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user()->load(['address', 'phones']);
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

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phones' => $request->input('phone'),
            'city' => $request->input('city'),
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
                    'city' => $data['city'],
                    'country' => $data['country'],
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
            'city' => 'required|string',
        ]);

        $city = $request->city;

        $cityData = Shipping::where('city_id', $city)->first();

        if ($cityData) {
            return response()->json(['deliveryCost' => $cityData->shipping_fee]);
        } else {
            return response()->json(['deliveryCost' => 0], 400);
        }
    }
}

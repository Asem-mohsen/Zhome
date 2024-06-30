<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Promocode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutContoller extends Controller
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
        $orders = ShopOrders::where($identifier)
                    ->with('product.sale' , 'transaction' , 'user' , 'promocode') 
                    ->get();
        $total = $orders->sum(function ($order) {
                return $order->Quantity * $order->Price + 
                    ($order->WithInstallation ? $order->product->InstallationCost : 0);
                });
                
        $userData = null;
        $firstName = '';
        $lastName = '';

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $userData = $user;

            $nameParts = explode(' ', $user->Name);
            $firstName = $nameParts[0];
            $lastName = count($nameParts) > 1 ? end($nameParts) : '';
        } else {
            // Get the latest order for non-authenticated users
            $latestOrder = $orders->last();
            if ($latestOrder) {
                $userData = $latestOrder;

                $nameParts = explode(' ', $latestOrder->Name);
                $firstName = $nameParts[0];
                $lastName = count($nameParts) > 1 ? end($nameParts) : '';
            }
        }

        return view('User.Payment.checkout' , compact('orders', 'userData', 'firstName', 'lastName' ,'total'));
    }

    public function checkPromoCode(Request $request)
    {
        $request->validate([
            'promoCode' => 'required|string',
            'totalPrice' => 'required|numeric',
        ]);

        $promoCode = $request->promoCode;
        $totalPrice = $request->totalPrice;

        $promoCodeData = PromoCode::where('Promocode', $promoCode)->where('Status', 1)->first();

        if ($promoCodeData) {
                $discount = $totalPrice * ($promoCodeData->Save / 100);
                return response()->json(['discount' => $discount]);
        } else {
            return response()->json(['discount' => 0], 400);
        }
    }

    public function getDeliveryCost(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
        ]);

        $city = $request->city;

        $cityData = Delivery::where('City', $city)->where('Status' , 1)->first();

        if ($cityData) {
            return response()->json(['deliveryCost' => $cityData->Fees]);
        } else {
            return response()->json(['deliveryCost' => 0], 400);
        }
    }
    
}
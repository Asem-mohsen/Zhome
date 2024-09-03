<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Promocode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use App\Traits\HandleImgPath;
use App\Http\Requests\User\SaveUserInfoCheckout;


class CheckoutController extends Controller
{
    use ApiResponse , HandleImgPath;

    private function getIdentifier(Request $request)
    {
        if (Auth::guard('sanctum')->check()) {
            return ['UserID' => Auth::guard('sanctum')->user()->id];
        } else {
            $sessionId = $request->header('X-Session-ID');

            if ($sessionId) {
                // Ensure Laravel uses the provided session ID
                Session::setId($sessionId);
                Session::start();
            } else {
                $sessionId = Session::getId();
            }

            return ['SessionID' => $sessionId];
        }
    }

    public function index(Request $request)
    {
        $identifier = $this->getIdentifier($request);
    
        // Generate a unique CartID
        $cartId = Str::random(32);
    
        // Update orders with the generated CartID
        $updated = ShopOrders::where($identifier)->update(['CartID' => $cartId]);
    
        // Fetch the updated orders to ensure correct CartID is included
        $orders = ShopOrders::where($identifier)
                    ->with('product.sale', 'transaction', 'promocode')
                    ->get();
    
        // Calculate the total after fetching updated orders
        $total = $orders->sum(function ($order) {
            return $order->Quantity * $order->Price +
                ($order->WithInstallation ? $order->product->InstallationCost : 0);
        });
    
        $userData = null;
        $firstName = '';
        $lastName = '';
    
        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
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
    
        $data = [
            'CartID' => $cartId,  // The correct CartID is returned
            'firstName' => $firstName,
            'lastName' => $lastName,
            'total' => $total,
            'Orders' => $this->transformImagePaths($orders),
            'User' => $userData,
        ];
    
        if ($userData != null) {
            return $this->data($data, 'Checkout data retrieved successfully');
        } else {
            return $this->data($data, 'User must sign in or create an account to show his data and to continue to checkout');
        }
    }

    public function saveUserInfo(SaveUserInfoCheckout $request)
    {
        $identifier = $this->getIdentifier($request);
        
         // Prepare data for the orders table
        $orderData = $request->except('_token', '_method', 'Address');
        
        $orderData['Name'] = $request->Name;
        $orderData['Email'] = $request->email;
        $orderData['Phone'] = $request->Phone;
        $orderData['Address'] = $request->UserShippingAddress; // Shipping address for the order
        $orderData['Building'] = $request->Building;
        $orderData['Floor'] = $request->Floor;
        $orderData['Apartment'] = $request->Apartment;
        unset($orderData['UserShippingAddress']);

        ShopOrders::where($identifier)
                    ->where('CartID', $request->CartID)
                    ->update($orderData);
                    
        $userData = $request->except('_token', '_method','UserShippingAddress');
        
        $userData = [
            'Name' => $request->Name,
            'Email' => $request->email,
            'Phone' => $request->Phone,
            'Address' => $request->Address,
        ];
    
        // Update user table
        User::where('id', $request->UserID)->update($userData);

        return $this->success('User data updated successfully' , 200);
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
                $total = $totalPrice - $discount ;
                return $this->data(['discount' => $discount , 'total' => $total] , 'Disscount Applied Successfully' , 200);
        } else {
            return $this->error(['message'=>'Invalid Promocode'] , 'Invalid Promocode' , 404);
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
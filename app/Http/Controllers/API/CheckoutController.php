<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Checkout\{ CheckPromocodeRequest , GetDeliveryEstimationRequest , GetDeliveryCostRequest, SaveUserInfoCheckout};
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    protected $pending = OrderStatusEnum::PENDING->value;

    public function __construct(private CheckoutService $checkoutService, private CartService $cartService)
    {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $response = $this->checkoutService->getCheckoutData($request);
        return successResponse($response, 'Checkout data retrieved successfully');
    }

    public function saveUserInfo(SaveUserInfoCheckout $request)
    {
        $this->checkoutService->saveUserInformation($request);
        return successResponse(message: 'User data updated successfully');
    }

    public function checkPromoCode(CheckPromocodeRequest $request)
    {
        $response = $this->checkoutService->validatePromoCode($request);

        return $response['success']
            ? successResponse($response['data'], 'Discount applied successfully')
            : failureResponse('Invalid Promocode', 404);
    }

    public function getDeliveryCost(GetDeliveryCostRequest $request)
    {
        $response = $this->checkoutService->calculateDeliveryCost($request);
        return successResponse($response, 'Delivery cost retrieved successfully');
    }

    public function getDeliveryEstimations(GetDeliveryEstimationRequest $request)
    {
        $response = $this->checkoutService->fetchDeliveryEstimations($request);
        return successResponse(['data' => $response], 'Delivery estimations retrieved successfully');
    }
}

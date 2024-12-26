<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ToolOrder;

class ToolsOrderController extends Controller
{
    public function index()
    {
        $orders = ToolOrder::with(['option'])->get();

        return successResponse(compact('orders'), 'orders data retrieved successfully');
    }

    public function show(ToolOrder $toolsorder)
    {
        $toolsorder->load(['toolCategories' ,'option' ,'platforms']);

        return successResponse(compact('toolsorder'), 'order data retrieved successfully');
    }

    public function destroy(ToolOrder $toolsorder)
    {
        try {
            $toolsorder->delete();

            return successResponse(message:'Tool Order Deleted Successfully');

        } catch (\Exception $e) {
            return failureResponse(message:'Failed to delete Order');
        }

    }
}

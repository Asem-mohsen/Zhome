<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ToolOrder;
use App\Traits\ApiResponse;

class ToolsOrderController extends Controller
{
    use ApiResponse;

    public function index()
    {

        $orders = ToolOrder::with(['option'])->get();

        return $this->data(compact('orders'), 'orders data retrieved successfully');
    }

    public function show(ToolOrder $toolsorder)
    {

        $toolsorder->load(['toolCategories' ,'option' ,'platforms']);

        return $this->data(compact('toolsorder'), 'order data retrieved successfully');

    }

    public function destroy(ToolOrder $toolsorder)
    {
        try {
            $toolsorder->delete();

            return $this->success('Tool Order Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Order');

        }

    }
}

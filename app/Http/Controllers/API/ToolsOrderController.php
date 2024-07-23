<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ToolsOrders;
use App\Models\ToolsCategories;
use App\Traits\ApiResponse;

class ToolsOrdersController extends Controller
{

    use ApiResponse;

    public function index(){

        $orders = ToolsOrders::with(['user'])->get();

        return $this->data($orders->toArray(), 'orders data retrieved successfully');
    }

    public function show(ToolsOrders $toolsorders){

        $order = $toolsorders::with(['user' ,'toolsCategories'])->first();

        return $this->data($order->toArray(), 'order data retrieved successfully');

    }

    public function destroy(ToolsOrders $toolsorders){

        try {

            ToolsCategories::where('ToolOrderID' , $toolsorders->ID)->delete();

            $toolsorders::where('ID' , $toolsorders->ID)->delete();

            return $this->success('Tool Order Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Order');
        
        }
        
    }
}

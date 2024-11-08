<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\Product;
use Carbon\Carbon;
use App\Traits\ApiResponse;

class InventoryController extends Controller
{
    use ApiResponse;

    public function index(){

        $products      = Product::with(['brand', 'platforms', 'subcategory.category'])->get();
        $totalProducts = Product::all()->count();
        $soldOut       = Product::where('Quantity', 0)->count();
        $aboutToEnd    = Product::where('Quantity', '<=' , 3)->count();
        $newest        = Product::where('created_at', '>=' , Carbon::now())->count();

        // Calculate the number of users who ordered each product
        $products->each(function ($product) {

            $product->orderedByUsersCount = $product->orderedByUsers()->distinct('UserID')->count();

        });

        $data = [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'aboutToEnd' => $aboutToEnd,
            'newest' => $newest,
            'soldOut' => $soldOut
        ];

        return $this->data($data, 'data retrieved successfully');

    }

    public function update(Request $request)
    {
        $request->validate([

            'quantityId'     => 'required|integer|exists:product,ID',

            'updatedQuantity'=> 'required|integer|min:0',

        ]);

        $product = Product::where('ID',$request->quantityId);

        $product->Quantity = $request->updatedQuantity;

        if ($product->update(['Quantity'=>$product->Quantity])) {

            return $this->success('Inventory Updated Successfully');

        } else {

            return $this->error('Failed to update quantity');

        }
    }
}
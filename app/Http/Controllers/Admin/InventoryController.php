<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\Product;
use Carbon\Carbon;

class InventoryController extends Controller
{
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
        return view('Admin.Inventory.index' , compact('products' , 'totalProducts' , 'soldOut' , 'aboutToEnd' , 'newest'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantityId' => 'required|integer|exists:product,ID',
            'updatedQuantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->quantityId);
        $product->Quantity = $request->updatedQuantity;
        $product->save();

        if ($product->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update quantity.']);
        }
    }
}
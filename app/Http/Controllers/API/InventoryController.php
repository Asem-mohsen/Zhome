<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Inventory\UpdateInventoryRequest;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {

        $products = Product::with(['brand', 'platforms', 'translations'])
            ->withCount([
                'users as ordered_by_users_count' => function (Builder $query) {
                    $query->distinct('user_id');
                },
            ])
            ->get();

        $inventoryStats = Product::selectRaw('
                            COUNT(*) as total_products,
                            COUNT(CASE WHEN quantity = 0 THEN 1 END) as sold_out,
                            COUNT(CASE WHEN quantity <= 3 THEN 1 END) as about_to_end,
                            COUNT(CASE WHEN created_at >= ? THEN 1 END) as newest
                        ', [Carbon::now()])->first();

        $totalProducts = $inventoryStats->total_products;
        $soldOut = $inventoryStats->sold_out;
        $aboutToEnd = $inventoryStats->about_to_end;
        $newest = $inventoryStats->newest;


        $data = [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'aboutToEnd' => $aboutToEnd,
            'newest' => $newest,
            'soldOut' => $soldOut,
        ];

        return successResponse($data, 'data retrieved successfully');
    }

    public function update(UpdateInventoryRequest $request)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($validated['product_id']);
        $product->quantity = $request->updatedQuantity;
        $product->save();

        if ($product->save()) {

            return successResponse(message: 'Inventory Updated Successfully');

        } else {
            return failureResponse(message: 'Failed to update quantity');
        }
    }
}

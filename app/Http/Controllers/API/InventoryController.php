<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    use ApiResponse;

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
                        ', [Carbon::now()])
            ->first();

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

        return $this->data($data, 'data retrieved successfully');

    }

    public function update(Request $request)
    {
        $request->validate([

            'quantityId' => 'required|integer|exists:product,ID',

            'updatedQuantity' => 'required|integer|min:0',

        ]);

        $request->validate([
            'quantityId' => 'required|integer|exists:products,id',
            'updatedQuantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->quantityId);
        $product->quantity = $request->updatedQuantity;
        $product->save();

        $product = Product::findOrFail($request->quantityId);

        $product->quantity = $request->updatedQuantity;

        $product->save();

        if ($product->save()) {

            return $this->success('Inventory Updated Successfully');

        } else {
            return $this->error(["error" => 'Failed to update quantity'] , 'Failed to update quantity');
        }
    }
}

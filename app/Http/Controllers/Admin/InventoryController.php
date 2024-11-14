<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
                        ', [Carbon::now()])
            ->first();

        $totalProducts = $inventoryStats->total_products;
        $soldOut = $inventoryStats->sold_out;
        $aboutToEnd = $inventoryStats->about_to_end;
        $newest = $inventoryStats->newest;

        return view('Admin.Inventory.index', get_defined_vars());
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantityId' => 'required|integer|exists:products,id',
            'updatedQuantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->quantityId);
        $product->quantity = $request->updatedQuantity;
        $product->save();

        if ($product->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update quantity.']);
        }
    }
}

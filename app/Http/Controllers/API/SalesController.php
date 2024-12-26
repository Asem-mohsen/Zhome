<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddSaleRequest, UpdateSaleRequest};
use App\Models\{Product , Sale};

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['products'])->get();

        return successResponse( $sales->toArray(), message: 'sales data retrieved successfully');
    }

    public function create()
    {
        $products = Product::whereDoesntHave('sale')->get();

        return successResponse( $products->toArray() , message: 'products for creating a sale retrieved successfully');
    }

    public function edit(Sale $sales)
    {
        $sale = Sale::with(['products'])->where('ProductID', $sales->ProductID)->first();

        return successResponse( $sale->toArray() , message: 'sale for editing retrieved successfully');
    }

    public function getProductPrice($productId)
    {

        $price = Product::where('ID', $productId)->select('Price')->first();

        return response()->json($price);
    }

    public function store(AddSaleRequest $request)
    {
        $data = $request->except('_token', '_method');

        $data['start_date'] = now();

        if (is_array($data['product_id'])) {

            foreach ($data['product_id'] as $productId) { // Group Sale

                $product = Product::findOrFail($productId);

                $data['sale_price'] = $product->price - ($product->price * $request->sale_price / 100);

                Sale::create(array_merge($data, ['product_id' => $productId]));

            }
        } else {

            Sale::create($data); // Sigle Sale

        }

        return successResponse(message: 'Sale Added Successfully');
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {

        $data = $request->except('_token', '_method');

        $data['start_date'] = now();

        Sale::where('product_id', $request->id)->update($data);

        return successResponse(message: 'Sale Updated Successfully');
    }

    public function destroy(Sale $sale)
    {

        try {
            $sale->delete();

            return successResponse(message: 'Sale with id : '.$sale->id.' Delete Successfully');
        } catch (\Exception $e) {
            return failureResponse(message: 'Failed to delete sale');
        }

    }
}

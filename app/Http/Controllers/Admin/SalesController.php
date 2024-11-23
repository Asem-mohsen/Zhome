<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['product.translations'])->get();

        return view('Admin.Sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();

        return view('Admin.Sales.create', compact('products'));
    }

    public function edit(Sale $sale)
    {
        $sale->load('product');

        return view('Admin.Sales.edit', compact('sale'));
    }

    public function createGroup()
    {
        $products = Product::whereDoesntHave('sale')->get();

        return view('Admin.Sales.createGroup', compact('products'));
    }

    public function store(AddSaleRequest $request)
    {
        $data = $request->except('_token', '_method');

        if (is_array($data['product_id'])) {
            // Group Sale
            foreach ($data['product_id'] as $productId) {
                Sale::create(array_merge($data, ['product_id' => $productId]));
            }
            toastr()->success(message: 'Sale created successfully');

        } else {

            Sale::create($data); // Sigle Sale

            toastr()->success(message: 'Sale created successfully');
        }

        return redirect()->route('Sales.index');
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $data = $request->except('_token', '_method');

        $sale->update($data);

        toastr()->success(message: 'Sale updated successfully');

        return redirect()->route('Sales.index')->with('success', 'Sale Updated Successfully');
    }
}

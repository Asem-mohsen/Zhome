<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Traits\ApiResponse;


class SalesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $sales = Sale::with(['products'])->get();
        
        return $this->data($sales->toArray(), 'sales data retrieved successfully');

    }

    public function create()
    {

        $products = Product::all();

        return $this->data($products->toArray(), 'products for creating a sale retrieved successfully');
    
    }

    public function edit(Sale $sales)
    {

        $sale = Sale::with(['products'])->where('ProductID' , $sales->ProductID)->first();
        
        return $this->data($sale->toArray(), 'sale for editing retrieved successfully');

    }

    
    public function createGroup()
    {
        $products = Product::whereDoesntHave('sale')->get();

        return $this->data($products->toArray(), 'products for sale retrieved successfully');
    }

    public function getProductPrice($productId)
    {
        
        $price = Product::where('ID' ,$productId)->select('Price')->first();
        
        return response()->json($price);
    }

    public function store(AddSaleRequest $request)
    {

        $data = $request->except('_token','_method');

        $data['StartDate'] = now();

        if (is_array($data['ProductID'])) {

            foreach ($data['ProductID'] as $productId) { // Group Sale

                $product = Product::where('ID', $productId)->first();

                $data['PriceAfter'] = $product->Price - ($product->Price * $request->Amount / 100 );
                
                Sale::create(array_merge($data, ['ProductID' => $productId]));

            }
        } else {

            Sale::create($data); // Sigle Sale

        }

        return $this->success('Sale Added Successfully');

    }

    public function update(UpdateSaleRequest $request , Sale $sale)
    {
        
        $data = $request->except('_token','_method');

        $data['StartDate'] = now();
 
        Sale::where('ProductID' , $request->ProductID)->update($data);

        return $this->success('Sale Updated Successfully');

    }
    
}
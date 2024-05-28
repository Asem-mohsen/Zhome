<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sale;


class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['products'])->get();
        
        return view('Admin.Sales.index' , compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('Admin.Sales.create' , compact('products'));
    }

    public function edit(Sale $sales)
    {
        $sale = Sale::with(['products'])->where('ProductID' , $sales->ProductID)->first();
        
        return view('Admin.Sales.edit' , compact('sale'));
    }

    
    public function createGroup()
    {
        $products = Product::whereDoesntHave('sale')->get();
        return view('Admin.Sales.createGroup' , compact('products'));
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
            // Group Sale
            foreach ($data['ProductID'] as $productId) {
                $product = Product::where('ID', $productId)->first();
                $data['PriceAfter'] = $product->Price - ($product->Price * $request->Amount / 100 );
                Sale::create(array_merge($data, ['ProductID' => $productId]));
            }
        } else {
            // Sigle Sale
            Sale::create($data);
        }

        return redirect()->route('Sales.index')->with('success','Sale Created Successfully');
    }

    public function update(UpdateSaleRequest $request , Sale $sale)
    {
        $data = $request->except('_token','_method');
        $data['StartDate'] = now();
 
        Sale::where('ProductID' , $request->ProductID)->update($data);


        return redirect()->route('Sales.index')->with('success','Sale Updated Successfully');
    }
    
}
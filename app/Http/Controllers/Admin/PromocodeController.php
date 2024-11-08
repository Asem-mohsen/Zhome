<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AddPromocodeRequest;
use App\Http\Requests\Admin\UpdatePromocodeRequest;
use App\Models\Promotion;
use Illuminate\Support\Carbon;


class PromocodeController extends Controller
{
    public function index()
    {
        $promotions = Promotion::withCount('orders')->get();
        
        return view('Admin.Sales.Promocode.index' , compact('promotions'));
    }

    public function create()
    {
        return view('Admin.Sales.Promocode.create');
    }

    public function store(AddPromocodeRequest $request)
    {
        $data = $request->except('_token','_method');

        Promotion::create($data);

        return redirect()->route('Sales.Promocode.index')->with('success','Promocode Created Successfully');
    }

    public function edit(Promotion $promotion)
    {
        return view('Admin.Sales.Promocode.edit' , compact('promotion'));
    }

    public function update(UpdatePromocodeRequest $request, Promotion $promotion)
    {
        $data = $request->except('_token','_method');

        $promotion->update($data);

        return redirect()->route('Sales.Promocode.index')->with('success','Promocode Updated Successfully');
    }

    public function destroy(Promotion $promotion){

        if($promotion->valid_until > now()){

            return redirect()->route('Sales.Promocode.index')->with('error', 'Cannot delete a promocode that has not expired yet. Expires on: ' . $promocode->EndsIn->format('Y-m-d H:i:s'));

        }else{      

            $promotion->delete();

            return redirect()->route('Sales.Promocode.index')->with('success','Promocode Deleted Successfully');
        }
    }
}


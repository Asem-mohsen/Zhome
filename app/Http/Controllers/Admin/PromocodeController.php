<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Admin\AddPromocodeRequest;
use App\Http\Requests\Admin\UpdatePromocodeRequest;
use App\Models\Promocode;
use App\Models\ShopOrders;
use Illuminate\Support\Carbon;


class PromocodeController extends Controller
{
    public function index(){
        $promocodes = Promocode::all();
        $promocodesWithUsage = [];
        foreach($promocodes as $promocode){
            $countUsed = ShopOrders::where('PromoCodeID', $promocode->ID)->count();
            $promocode->countUsed = $countUsed;
            $promocodesWithUsage[] = $promocode;
        }
        return view('Admin.Sales.Promocode.index' , compact('promocodesWithUsage'));
    }

    public function create(){
        return view('Admin.Sales.Promocode.create');
    }

    public function store(AddPromocodeRequest $request)
    {
        $data = $request->except('_token','_method');
        $availableForDays = (int) $request->AvailableFor;

        $data['EndsIn'] = now()->copy()->addDays($availableForDays);

        Promocode::create($data);

        return redirect()->route('Sales.Promocode.index')->with('success','Promocode Created Successfully');
    }

    public function edit(Promocode $promocode){
        return view('Admin.Sales.Promocode.edit' , compact('promocode'));
    }

    public function update(UpdatePromocodeRequest $request, Promocode $promocode)
    {
        $data = $request->except('_token','_method');
        $availableForDays = (int) $request->AvailableFor;

        $data['EndsIn'] = now()->copy()->addDays($availableForDays);

        Promocode::where('ID' , $promocode->ID)->update($data);

        return redirect()->route('Sales.Promocode.index')->with('success','Promocode Updated Successfully');
    }

    public function destroy(Promocode $promocode){

        if($promocode->EndsIn > now()){
            return redirect()->route('Sales.Promocode.index')->with('error', 'Cannot delete a promocode that has not expired yet. Expires on: ' . $promocode->EndsIn->format('Y-m-d H:i:s'));

        }else{
            ShopOrders::where('PromoCodeID', $promocode->ID)->update(['PromoCodeID' => null]);
            
            $promocode::where('ID' , $promocode->ID)->delete();
            return redirect()->route('Sales.Promocode.index')->with('success','Promocode Deleted Successfully');
        }
    }
}


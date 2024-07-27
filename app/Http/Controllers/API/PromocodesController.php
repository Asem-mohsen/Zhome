<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Admin\AddPromocodeRequest;
use App\Http\Requests\Admin\UpdatePromocodeRequest;
use App\Models\Promocode;
use App\Models\ShopOrders;
use Illuminate\Support\Carbon;
use App\Traits\ApiResponse;

class PromocodeController extends Controller
{
    
    use ApiResponse;

    public function index()
    {

        $promocodes = Promocode::all();

        $promocodesWithUsage = [];

        foreach($promocodes as $promocode){

            $countUsed = ShopOrders::where('PromoCodeID', $promocode->ID)->count();

            $promocode->countUsed = $countUsed;

            $promocodesWithUsage[] = $promocode;

        }

        return $this->data($promocodesWithUsage->toArray(), 'Promocode data retrieved successfully');
    }

    public function store(AddPromocodeRequest $request)
    {
        $data = $request->except('_token','_method');

        $availableForDays = (int) $request->AvailableFor;

        $data['EndsIn'] = now()->copy()->addDays($availableForDays);

        Promocode::create($data);

        return $this->success('Promocode Created Successfully');

    }

    public function edit(Promocode $promocode)
    {

        return $this->data($promocode->toArray(), 'promocode for editing retrieved successfully');

    }

    public function update(UpdatePromocodeRequest $request, Promocode $promocode)
    {
        $data = $request->except('_token','_method');

        $availableForDays = (int) $request->AvailableFor;

        $data['EndsIn'] = now()->copy()->addDays($availableForDays);

        Promocode::where('ID' , $promocode->ID)->update($data);

        return $this->success('Promocode Updated Successfully');
    }

    public function destroy(Promocode $promocode)
    {

        try {

            if($promocode->EndsIn > now()){

                return $this->error('Cannot delete a promocode that has not expired yet. Expires on: ' . $promocode->EndsIn->format('Y-m-d H:i:s'));
    
            }else{

                ShopOrders::where('PromoCodeID', $promocode->ID)->update(['PromoCodeID' => null]);
                
                $promocode::where('ID' , $promocode->ID)->delete();

                return $this->success('Promocode Deleted Successfully');
                
            }

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Admin');
        
        }

        
    }
}


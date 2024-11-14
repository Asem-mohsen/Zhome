<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{AddShippingCostRequest , AddEstimationRequest };
use App\Models\{City, Country , Shipping ,DeliveryProductEstimation , Product};
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {

    }

    public function cost()
    {
        $shippings = Shipping::with('country' , 'city')->get();

        return view("Admin.Shipping.Cost.index" , compact("shippings"));
    }

    public function estimations()
    {
        $delivery = DeliveryProductEstimation::with('products.translations')->get();

        return view("Admin.Shipping.Estimation.index" , compact("delivery"));
    }

    public function costCreate()
    {
        $countries = Country::all();

        return view("Admin.Shipping.Cost.create" , compact("countries"));
    }

    public function estimationCreate()
    {
        $products = Product::with('translations')->get();

        return view("Admin.Shipping.Estimation.create" , compact("products"));
    }

    public function costStore(AddShippingCostRequest $request)
    {
        try {
            $validated = $request->validated();
    
            Shipping::create([
                'country_id' => $validated['country_id'],
                'city_id' => $validated['city_id'],
                'shipping_fee' => $validated['shipping_fee'], 
            ]);
    
            toastr()->success('Shipping data saved successfully.');
            
        } catch (\Exception $e) {
            toastr()->error('An error occurred while saving the shipping data. Please try again.');
        }
    
        return redirect()->back();
    }

    public function estimationStore(AddEstimationRequest $request)
    {
        try {
            $validated = $request->validated();
    
            if (empty($request->product_id)) {
                toastr()->error('Please select at least one product.');
                return redirect()->back();
            }

            $deliveryEstimation = DeliveryProductEstimation::create([
                'estimation_details' => $request->estimation_details,
                'estimated_delivery_date' => $request->estimated_delivery_date,
            ]);

            $deliveryEstimation->products()->attach($request->product_id);

            toastr()->success('Estimation data saved successfully.');
            
        } catch (\Exception $e) {
            toastr()->error('An error occurred while saving the estimation data. Please try again.');
        }

        return redirect()->route('Shipping.estimations.index');
    }

    public function editCost(Shipping $shipping)
    {
        $countries = Country::all();

        return view("Admin.Shipping.Cost.edit" , compact("shipping", "countries"));
    }

    public function editEstimation(DeliveryProductEstimation $estimation)
    {
        $products = Product::with('translations')->get();

        $selectedProductIds = $estimation->products->pluck('id')->toArray(); 

        return view("Admin.Shipping.Estimation.edit" , compact("estimation" , "products" , "selectedProductIds"));
    }

    public function costUpdate(AddShippingCostRequest $request , Shipping $shipping)
    {
        try {
            $validated = $request->validated();
    
            $shipping->update([
                'country_id' => $validated['country_id'],
                'city_id' => $validated['city_id'],
                'shipping_fee' => $validated['shipping_fee'], 
            ]);
    
            toastr()->success('Shipping data saved successfully.');
            
        } catch (\Exception $e) {
            toastr()->error('An error occurred while saving the shipping data. Please try again.');
        }
    
        return redirect()->back();
    }

    public function estimationUpdate(AddEstimationRequest $request , DeliveryProductEstimation $estimation)
    {
        try {
            $validated = $request->validated();
    
            if (empty($request->product_id)) {
                toastr()->error('Please select at least one product.');
                return redirect()->back();
            }
        
            $estimation->update([
                'estimation_details' => $request->estimation_details,
                'estimated_delivery_date' => $request->estimated_delivery_date,
            ]);
    
            $estimation->products()->sync($request->product_id);
    
            toastr()->success('Estimation data updated successfully.');
    
        } catch (\Exception $e) {
            toastr()->error('An error occurred while updating the estimation data. Please try again.');
            return redirect()->back();
        }
    
        return redirect()->route('Shipping.estimations.index');
    }

    public function costDelete(Shipping $shipping)
    {
        try {    
            $shipping->delete();
    
            toastr()->success('Shipping deleted successfully.');
            
        } catch (\Exception $e) {
            toastr()->error('An error occurred while deleting the shipping data. Please try again.');
        }

        return redirect()->route('Shipping.cost.index');
    }

    public function estimationDelete(DeliveryProductEstimation $estimation)
    {
        try {    
            $estimation->delete();
    
            toastr()->success('Delivery products estimations deleted successfully.');
            
        } catch (\Exception $e) {
            toastr()->error('An error occurred while deleting the products estimations data. Please try again.');
        }

        return redirect()->route('Shipping.estimations.index');
    }
    public function getCities($country_id)
    {
        $cities = City::where('country_id', $country_id)->get(['id', 'name']); 

        return response()->json($cities);
    }
}

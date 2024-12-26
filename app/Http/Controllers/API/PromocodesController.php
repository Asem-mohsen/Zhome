<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddPromocodeRequest;
use App\Http\Requests\Admin\UpdatePromocodeRequest;
use App\Models\{Promotion ,Order } ;

class PromocodesController extends Controller
{
    public function index()
    {
        $promotions = Promotion::withCount('orders')->get();

        return successResponse( compact('promotions'), 'Promocode data retrieved successfully');
    }

    public function store(AddPromocodeRequest $request)
    {
        $data = $request->except('_token', '_method');

        Promotion::create($data);

        return successResponse( message:'Promocode Created Successfully');
    }

    public function edit(Promotion $promotion)
    {
        return successResponse(compact('promotion'), 'promocode for editing retrieved successfully');
    }

    public function update(UpdatePromocodeRequest $request, Promotion $promotion)
    {
        $data = $request->except('_token', '_method');

        $promotion->update($data);

        return successResponse(message: 'Promocode Updated Successfully');
    }

    public function destroy(Promotion $promotion)
    {

        if ($promotion->valid_until > now()) {

            return failureResponse(message: 'Cannot delete a promocode that has not expired yet. Expires on: ' . $promotion->valid_until->format('Y-m-d H:i:s'));

        } else {
            $promotion->delete();

            return successResponse(message: 'Promocode Deleted Successfully');
        }
    }
}

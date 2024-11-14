<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddPromocodeRequest;
use App\Http\Requests\Admin\UpdatePromocodeRequest;
use App\Models\{Promotion ,Order } ;
use App\Traits\ApiResponse;

class PromocodesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $promotions = Promotion::withCount('orders')->get();

        return $this->data(compact('promotions'), 'Promocode data retrieved successfully');
    }

    public function store(AddPromocodeRequest $request)
    {
        $data = $request->except('_token', '_method');

        Promotion::create($data);

        return $this->success('Promocode Created Successfully');

    }

    public function edit(Promotion $promotion)
    {

        return $this->data(compact('promotion'), 'promocode for editing retrieved successfully');

    }

    public function update(UpdatePromocodeRequest $request, Promotion $promotion)
    {
        $data = $request->except('_token', '_method');

        $promotion->update($data);

        return $this->success('Promocode Updated Successfully');
    }

    public function destroy(Promotion $promotion)
    {

        if ($promotion->valid_until > now()) {

            return $this->error(['error' => 'Cannot delete a promocode that has not expired yet. Expires on: '.$promotion->valid_until->format('Y-m-d H:i:s')], 'Eror');

        } else {

            $promotion->delete();

            return $this->success('Promocode Deleted Successfully');

        }
    }
}

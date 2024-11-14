<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddPromocodeRequest;
use App\Http\Requests\Admin\UpdatePromocodeRequest;
use App\Models\Promotion;

class PromocodeController extends Controller
{
    public function index()
    {
        $promotions = Promotion::withCount('orders')->get();

        return view('Admin.Sales.Promocode.index', compact('promotions'));
    }

    public function create()
    {
        return view('Admin.Sales.Promocode.create');
    }

    public function store(AddPromocodeRequest $request)
    {
        $data = $request->except('_token', '_method');

        Promotion::create($data);

        toastr()->success(message: 'promotion created successfully!');

        return redirect()->route('Sales.Promocode.index');
    }

    public function edit(Promotion $promotion)
    {
        return view('Admin.Sales.Promocode.edit', compact('promotion'));
    }

    public function update(UpdatePromocodeRequest $request, Promotion $promotion)
    {
        $data = $request->except('_token', '_method');

        $promotion->update($data);

        toastr()->success(message: 'promotion updated successfully!');

        return redirect()->route('Sales.Promocode.index');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->status === 'disactive') {
            $promotion->delete();
            toastr()->success('Promotion deleted successfully!');
            return redirect()->route('Sales.Promocode.index');
        }

        if ($promotion->valid_until > now()) {
            toastr()->error('Cannot delete a promotion that has not expired yet. Expires on: ' . $promotion->valid_until->format('Y-m-d H:i:s'));
            return redirect()->route('Sales.Promocode.index');
        }
    
        if ($promotion->valid_until <= now() && $promotion->status === 'active') {
            toastr()->error('Promotion cannot be deleted while it is still active.');
            return redirect()->route('Sales.Promocode.index');
        }

    }
}

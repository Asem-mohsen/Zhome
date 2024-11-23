<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddNewToolRequest;
use App\Models\{ Platform, ToolOrder};
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToolsController extends Controller
{
    use ApiResponse ;

    public function index()
    {
        $platforms = Platform::all();

        return $this->data(compact('platforms'), 'Platforms Retrieved Successfully');
    }

    public function interior()
    {
        $platforms = Platform::all();

        return $this->data(compact('platforms'), 'Platforms Retrieved Successfully');
    }

    public function store(AddNewToolRequest $request)
    {
        try {
            $data = $request->except('_method', '_token', 'categories', 'room_input', 'file', 'platform_id', 'installed', 'system_type', 'package');
            
            $toolOrder = ToolOrder::create($data);
            
            $data['rooms'] = $request->input('room_input') ?? $request->input('rooms');
    
            $toolOrder->option()->create([
                'installed' => $request->input('installed'),
                'package' => $request->input('package'),
                'system_type' => $request->input('system_type'),
                'building_type' => $request->input('building_type'),
                'rooms' => $data['rooms'],
            ]);
    
            $platformIds = $request->input('platform_id', []);
            if (!empty($platformIds)) {
                $toolOrder->platforms()->sync($platformIds);
            }
    
            $categories = $request->input('categories', []);
            foreach ($categories as $categoryName) {
                $toolOrder->toolCategories()->create([
                    'tool_order_id' => $toolOrder->id,
                    'name' => $categoryName,
                ]);
            }
    
            if ($request->hasFile('file')) {
                $toolOrder->addMediaFromRequest('file')->toMediaCollection('house_documents');
            }
    
            return $this->success('Design selected successfully. We will contact you as soon as possible.');
    
        } catch (\Exception $e) {

            Log::error('Tool Order Creation Error: ' . $e->getMessage());
    
            return $this->error(['message'=>'Ann error occurred while processing your request. Please try again later.'],'An error occurred while processing your request. Please try again later.');
        }
    }
    
}

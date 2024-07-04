<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Models\ToolsCategories;
use App\Models\ToolsOrders;
use App\Http\Requests\User\AddNewToolRequest;
use App\Http\Services\Media;



class ToolsController extends Controller
{
    public function index()
    {
        $platforms = Platform::all();
        return view('User.Tools.proposal' , compact('platforms'));
    }

    public function interior()
    {
        $platforms = Platform::all();
        return view('User.Tools.interior' , compact('platforms'));
    }

    public function store(AddNewToolRequest $request)
    {
        // dd($request);
        $data = $request->except('_method' , '_token' , 'Categories' ,'RoomsInput' , 'file');

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $userName = $data['Name'];
            $filename = $userName .'_' . time() . '_' . $file->getClientOriginalName();
            $filePath = 'Admin/dist/img/web/Tools/UserFiles';
            $newFileName = $file->storeAs($filePath, $filename, 'public');
            $data['PlanHouseDocument'] = $filename;
        }

        // Use 'Rooms' input if 'RoomsInput' is null
        if ($request->input('RoomsInput') === null) {
            $data['Rooms'] = $request->input('Rooms');
        } else {
            $data['Rooms'] = $request->input('RoomsInput');
        }


        $toolOrder = ToolsOrders::create($data);

        // Iterate over each category and create a ToolsCategories record
        $categories = $request->input('Categories', []);

        if (is_string($categories)) {
            $categories = explode(',', $categories);
        }
        foreach ($categories as $category) {
            $toolCategoryData = [
                'ToolOrderID' => $toolOrder->id,
                'Category' => $category, // Assuming the category data contains the category ID
            ];
            ToolsCategories::create($toolCategoryData);
        }
        return redirect()->route('Tools.index')->with('success', 'Design selected successfully we will contact you as soon as possible');

    }
}

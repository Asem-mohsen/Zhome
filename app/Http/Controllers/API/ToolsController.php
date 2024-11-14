<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddNewToolRequest;
use App\Models\Platform;
use App\Models\ToolsCategories;
use App\Models\ToolsOrders;
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;
use Illuminate\Support\Facades\Auth;

class ToolsController extends Controller
{
    use ApiResponse , HandleImgPath;

    public function index()
    {
        $platforms = Platform::all();
        $platforms = $this->transformImagePaths($platforms);

        return $this->data(compact('platforms'), 'Platforms Retrieved Successfully');
    }

    public function interior()
    {
        $platforms = Platform::all();

        return $this->data(compact('platforms'), 'Platforms Retrieved Successfully');
    }

    public function store(AddNewToolRequest $request)
    {
        $data = $request->except('_method', '_token', 'Categories', 'RoomsInput', 'file');

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $userName = $data['Name'];
            $filename = $userName.'_'.time().'_'.$file->getClientOriginalName();
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
        // Handle user data
        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            $data['UserID'] = $user->id;
            $data['Name'] = $user->Name;
            $data['Email'] = $user->email;
            $data['Phone'] = $user->Phone;
            $data['Address'] = $user->Address;

            $data['Country'] = $user->Country ?? $request->input('Country');
            $data['City'] = $user->City ?? $request->input('City');
        } else {
            $sessionId = $request->header('X-Session-ID');

            $data['UnkownID'] = $sessionId;

            $data['Name'] = $request->input('Name');
            $data['Email'] = $request->input('Email');
            $data['Phone'] = $request->input('Phone');
            $data['Address'] = $request->input('Address');
            $data['Country'] = $request->input('Country');
            $data['City'] = $request->input('City');
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
                'Category' => $category,
            ];
            ToolsCategories::create($toolCategoryData);
        }

        return $this->success('Design selected successfully we will contact you as soon as possible');
    }
}

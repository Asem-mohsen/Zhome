<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\ShopOrders;

class PromocodeController extends Controller
{
    public function index(){
        $promocodes = Promocode::all();
        $countUsed  = ShopOrders::whereNotNull('PromoCodeID')->count();
        return view('Admin.Sales.Promocode.index' , compact('promocodes' , 'countUsed'));
    }
}
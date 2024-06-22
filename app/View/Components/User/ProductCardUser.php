<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Sale;
use App\Models\Product;
use App\Models\ProductPlatforms;


class ProductCardUser extends Component
{
    public $variable;
    public $productID;

    public function __construct($variable, $productID)
    {
        $this->variable = $variable;
        $this->productID = $productID;
    }

    public function render()
    {
        $priceSale = Sale::where('ProductID', $this->productID)->first();
        $countSale = $priceSale ? 1 : 0;
        $platforms = Product::with(['platforms'])->get();

        return view('components.user.product-card-user', [
            'priceSale' => $priceSale,
            'countSale' => $countSale,
            'platforms' => $platforms,
        ]);

    }
}

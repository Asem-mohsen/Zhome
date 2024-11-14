<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ProductCardAdmin extends Component
{
    public $variable;

    public function __construct($variable)
    {
        $this->variable = $variable;
    }

    public function render()
    {
        return view('components.admin.product-card-admin');
    }
}

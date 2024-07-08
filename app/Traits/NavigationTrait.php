<?php

namespace App\Traits;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Brand;

trait NavigationTrait
{

    protected function getNavigationData()
    {
        $isMobile   = $this->isMobile();
        $isShop     = $this->isShopPage();
        $allCategories = Category::with('subcategories')->get();
        $navCategories = Category::whereHas('subcategories.products')
                            ->with(['subcategories' => function ($query) {
                                $query->whereHas('products');
                            }])->get();
        $brands     = Brand::all();
        $platforms  = Platform::all();

        return compact('isMobile', 'isShop', 'allCategories', 'navCategories', 'brands', 'platforms');
    }

    protected function isMobile()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    protected function isShopPage()
    {
        $shopRoutes = [
            'Shop.index',
            'Shop.FilterIndex',
            'Shop.Filter.category',
            'Shop.Filter.subcategory',
            'Shop.Filter.brand',
            'Shop.Filter.platform',
            'Cart.index',
        ];

        $route = request()->route();

        if (!$route) {
            return false;
        }

        return in_array($route->getName(), $shopRoutes);
    }

}
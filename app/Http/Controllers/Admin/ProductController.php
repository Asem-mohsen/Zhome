<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddProductRequest , UpdateProductRequest};
use App\Models\{ Brand ,Category , Feature , Platform ,Product ,Subcategory ,Technology};
use Exception;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('Admin.Products.index', compact('products'));
    }

    public function create()
    {
        return view('Admin.Products.create', [
            'products' => Product::all(),
            'brands' => Brand::all(),
            'platforms' => Platform::all(),
            'categories' => Category::all(),
            'features' => Feature::all(),
            'technologies' => Technology::all(),
        ]);
    }

    public function store(AddProductRequest $request)
    {
        try {
            $this->productService->storeProduct($request);
            toastr()->success('Product added successfully');
            return redirect()->route('Products.index');
        } catch (Exception $e) {
            Log::error('error'. $e->getMessage());

            toastr()->error('An error occurred while adding the product');
            return back()->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $platforms = Platform::all();
        $brands = Brand::all();
        $features = Feature::all();
        $technologies = Technology::all();

        return view('Admin.Products.edit', get_defined_vars());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->productService->updateProduct($request, $product);
            toastr()->success('Product updated successfully');
            return redirect()->route('Products.index');
        } catch (Exception $e) {

            Log::error('error'. $e->getMessage());
            toastr()->error('An error occurred while updating the product');
            return back()->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->deleteProduct($product);
            toastr()->success('Product deleted successfully');
            return redirect()->route('Products.index');
        } catch (Exception $e) {
            toastr()->error('An error occurred while deleting the product');
            return back();
        }
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }
}

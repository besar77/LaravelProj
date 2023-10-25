<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductSizeController extends Controller
{
    public function index(string $id): View
    {
        $sizes = ProductSize::where("product_id", $id)->get();
        $product = Product::findOrFail($id);
        $options = ProductOption::where("product_id", $id)->get();
        return view('admin.product.product-size.index', compact('product', 'sizes', 'options'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:150', 'price' => 'required|numeric', 'product_id' => 'required'
        ]);

        $size = new ProductSize();
        $size->product_id = $request->product_id;
        $size->name = $request->name;
        $size->price = $request->price;
        $size->save();
        toastr()->success('Created Successfully');
        return redirect()->back();
    }

    public function destroy($id): JsonResponse
    {
        try {
            $size = ProductSize::findOrFail($id);
            $size->delete();
            return response()->json(['status' => 'success', 'message' => 'Slider deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}

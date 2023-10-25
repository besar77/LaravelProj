<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index()
    {


        $sectionTitles = $this->getSectionTitles();
        $sliders = Slider::where("status", 1)->get();
        $whyChooseUs = WhyChooseUs::where("status", 1)->get();
        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();

        // $allProducts = collect();
        // foreach ($categories as $c) {
        //     $products = Product::where(['show_at_home' => 1, 'status' => 1, 'category_id' => $c->id])
        //         ->orderBy('id', 'desc')
        //         ->take(8)
        //         ->get();
        //     $allProducts = $allProducts->concat($products);
        // }

        // dd($allProducts);

        return view(
            'frontend.home.index',
            compact(
                'sliders',
                'sectionTitles',
                'whyChooseUs',
                'categories'
            )
        );
    }

    function getSectionTitles(): Collection
    {
        return SectionTitle::where('key', 'like', '%why_choose%')->get();
    }

    public function show(string $slug): View
    {
        $product = Product::with(['productImages', 'productSizes', 'productOptions'])->where(['slug' => $slug, 'status' => 1])->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('status', '!=', 0)
            ->where('id', '!=', $product->id)
            ->take(8)->latest()->get();
        // dd($relatedProducts);
        return view('frontend.pages.product-view', compact('product', 'relatedProducts'));
    }

    public function loadProductModal(string $productId)
    {
        $product = Product::with(['productSizes','productOptions'])->findOrFail($productId);
        return view('frontend.layouts.ajax-files.product-popup-modal' , compact('product'))->render(); //sends view like a json data

    }
}

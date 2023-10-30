<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
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
        $product = Product::with(['productSizes', 'productOptions'])->findOrFail($productId);
        return view('frontend.layouts.ajax-files.product-popup-modal', compact('product'))->render(); //sends view like a json data

    }

    public function applyCoupon(Request $request)
    {
        $code = $request->input('code');
        $subTotal = $request->input('subTotal');

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['message' => 'Invalid Coupon Code'], 422);
        }

        if ($coupon->quantity <= 0) {
            return response(['message' => 'Coupon has been fully redeemed'], 422);
        }

        if ($coupon->expire_date < now()) {
            return response(['message' => 'Coupon has expired'], 422);
        }

        if ($coupon->discount_type === 'percent') {
            $discount = $subTotal * ($coupon->discount / 100);
            $formattedDiscount = number_format($discount, 2);
        } elseif ($coupon->discount_type === 'amount') {
            $discount = $coupon->discount;
            $formattedDiscount = number_format($discount, 2);
        }

        $finalTotal = $subTotal - $formattedDiscount;
        $formattedPrice = number_format($finalTotal, 2);
        $formattedDiscount = number_format($discount, 2);

        session()->put('coupon', ['code' => $code, 'discount' => $formattedDiscount]);

        return response([
            'message' => 'Coupon applied successfully!',
            'discount' => $formattedDiscount, 'finalTotal' => $formattedPrice,
            'coupon_code' => $code
        ]);
    }

    public function destroyCoupon()
    {
        try {
            session()->forget('coupon');
            return response(['message' => 'Coupon Removed!', 'grandCartTotal' => grandCartTotal()], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something went wrong'], 500);
        }
    }
}

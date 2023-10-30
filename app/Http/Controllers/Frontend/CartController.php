<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{

    public function index(): View
    {
        return view("frontend.pages.cart-view");
    }

    //Add prod to cart
    public function addToCart(Request $request)
    {
        $product = Product::with(['productSizes', 'productOptions'])->findOrFail($request->product_id);
        if ($product->quantity < $request->quantity) {
            throw ValidationException::withMessages(['Maximum quantity for product: ' . $product->name . ' is: ' . $product->quantity]);
        }
        try {
            $productSize = $product->productSizes->where('id', $request->product_size)->first();
            $productOptions = $product->productOptions->whereIn('id', $request->product_option); //masi prej front po marrim shume id , whereIn per me i thirr shume rreshta me ato id

            $options = [
                'product_size' => [],
                'product_options' => [],
                'product_info' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug
                ],
            ];

            if ($productSize) {
                $options['product_size'][] = [
                    'id' => $productSize?->id,
                    'name' => $productSize?->name,
                    'price' => $productSize?->price
                ];
            }

            foreach ($productOptions as $option) {

                $options['product_options'][] = [
                    'id' => $option->id,
                    'name' => $option->name,
                    'price' => $option->price
                ];
            }

            // dd($options);
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity,
                'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
                'weight' => 0,
                'options' => $options
            ]);

            return response(['status' => 'success', 'message' => 'Product added into cart!'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }

    public function getCartProduct()
    {
        // $products = Cart::content();
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }

    public function cartProductRemove(string $rowId)
    {
        try {
            Cart::remove($rowId);

            return response([
                'status' => 'success', 'message' => 'Item has been removed!',
                'cart_total' => currencyPosition(cartTotal()),
                'grandCartTotal' => grandCartTotal(),
            ], 200);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Sorry , something went wrong!'], 500);
        }
    }

    public function cartQtyUpdate(Request $request): Response
    {
        $cartItem = Cart::get($request->rowId);
        $product = Product::findOrFail($cartItem->id);
        if ($product->quantity < $request->qty) {
            return response(['status' => 'error', 'message' => 'Quantity is not available!', 'qty' => $cartItem->qty]);
        }

        try {

            $rowId = $request->input('rowId');
            $qty = $request->input('qty');

            $cart = Cart::update($rowId, $qty);

            return response([
                'status' => 'success',
                'product_total' => productTotal($rowId),
                'qty' => $cart->qty,
                'cart_total' => currencyPosition(cartTotal()),
                'grandCartTotal' => grandCartTotal(),
            ], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }

    public function removeAllProds()
    {
        try {
            Cart::destroy();
            session()->forget('coupon');
            return response([
                'status' => 'success', 'message' => 'All products are removed from cart!',
                'cart_total' => currencyPosition(cartTotal()),
                'grandCartTotal' => grandCartTotal(),
            ], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }
}

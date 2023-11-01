<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index()
    {
        if (!session()->has('delivery_fee') || !session()->has('address')) {
            throw ValidationException::withMessages(['Something went wrong!']);
        }

        $subtotal = cartTotal();
        $deliveryFee = session('delivery_fee') ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $grandTotal = grandCartTotal($deliveryFee);
        return view('frontend.pages.payment', compact('subtotal', 'deliveryFee', 'discount', 'grandTotal'));
    }


    public function makePayment(Request $request, OrderService $orderService)
    {
        $request->validate([
            'paymentGateway' => 'required|string|in:paypal'
        ]);

        //Create order
        if ($orderService->createOrder()) {
            //redirect user to the payment host
            switch ($request->paymentGateway) {
                case 'paypal':
                    return response(['redirect_url' => route('paypal.payment')]);
                    break;

                default:
                    break;
            }
        }
    }

    public function payWithPaypal()
    {
    }
    public function paypalSuccess()
    {
    }
    public function paypalCancel()
    {
    }
}

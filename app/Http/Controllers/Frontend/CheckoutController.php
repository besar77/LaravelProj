<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        return view('frontend.pages.checkout', compact('userAddresses', 'deliveryAreas'));
    }

    public function deliveryCalc(Request $request)
    {
        try {
            $addressId = $request->input('addressId');
            $address = Address::findOrFail($addressId);
            $deliveryAmount = $address->deliveryArea->delivery_fee;
            $grandTotal = grandCartTotal($deliveryAmount);

            $formattedGrandTotal = number_format($grandTotal, 2, '.', ',');
            $formatteddeliveryAmount = number_format($deliveryAmount, 2, '.', ',');

            return response()->json(['delivery_fee' => $formatteddeliveryAmount, 'grand_total' => $formattedGrandTotal]);
        } catch (\Exception $e) {
            logger($e);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function checkoutRedirect(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $address = Address::with('deliveryArea')->findOrFail($request->input('id'));

        $selectedAddress = $address->address . ', Area: ' . $address->deliveryArea?->area_name;

        session()->put('address', $selectedAddress);
        session()->put('delivery_fee', $address->deliveryArea->delivery_fee);
        session()->put('delivery_area_id', $address->deliveryArea->id);



        return response(['redirect_url' => route('payment.index')]);
    }
}

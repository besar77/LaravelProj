<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    //Store Order in Database
    public function createOrder()
    {
        try {
            $order = new Order();
            $order->invoice_id = generateInvoiceId();
            $order->user_id = auth()->user()->id;
            $order->address = session()->get("address");
            $order->discount = session()->get("coupon")['discount'] ?? 0;
            $order->delivery_charge = session()->get('delivery_fee');
            $order->subtotal = cartTotal();
            $order->grand_total = grandCartTotal();
            $order->product_qty = \Cart::content()->count();
            $order->payment_method = NULL;
            $order->payment_status = 'pending';
            $order->payment_approve_date = NULL;
            $order->transaction_id = NULL;
            $order->coupon_info = json_encode(session()->get('coupon')) ?? '';
            $order->currency_name = NULL;
            $order->order_status = 'pending';
            $order->save();

            foreach (\Cart::content() as $prod) //ky \ e lejon me e kqyr si class
            {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_name = $prod->name;
                $orderItem->product_id = $prod->id;
                $orderItem->unit_price = $prod->price;
                $orderItem->qty = $prod->qty;
                $orderItem->product_size = json_encode($prod->options->product_size);
                $orderItem->product_option = json_encode($prod->options->product_options);
                $orderItem->save();
            }

            return true;
        } catch (\Exception $e) {
            logger($e);
            return false;
        }
    }

    //Clear Session items
    public function clearSession()
    {
    }
}

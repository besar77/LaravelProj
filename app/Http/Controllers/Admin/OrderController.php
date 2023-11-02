<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render("admin.order.index");
    }
    public function pendingOrdersIndex(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render("admin.order.order-pending-index");
    }
    public function inProcessOrdersIndex(InProcessOrderDataTable $dataTable)
    {
        return $dataTable->render("admin.order.order-in-process-index");
    }
    public function declinedOrdersIndex(DeclinedOrderDataTable $dataTable)
    {
        return $dataTable->render("admin.order.order-declined-index");
    }
    public function deliveredOrdersIndex(DeliveredOrderDataTable $dataTable)
    {
        return $dataTable->render("admin.order.order-delivered-index");
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    public function orderStatusUpdate(Request $request, string $id)
    {
        // dd('A jemi ne piken me id: '.$id);

        $request->validate([
            'payment_status' => 'required|in:completed,pending',
            'order_status' => 'required|in:pending,in_process,delivered,declined'
        ]);



        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if($request->ajax()){
            return response()->json(['message' => 'Order Status Was Updated Successfully']);
        }else{
            toastr()->success('Status updated successfully');
            return redirect()->back();
        }

    }

    public function getOrderStatus(string $id , Request $request){
        $order = Order::select(['payment_status','order_status'])->findOrFail($id);
        return response()->json($order);
    }

    public function destroy(string $id){
        try {
            $order = Order::findOrFail($id);
            // dd($whyChoseUs);
            $order->delete();

            return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong'], 500);
        }
    }
}

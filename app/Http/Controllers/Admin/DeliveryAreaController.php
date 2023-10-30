<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateDeliveryAreaRequest;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DeliveryAreaDataTable $dataTable)
    {
        return $dataTable->render('admin.delivery-area.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.delivery-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDeliveryAreaRequest $request)
    {
        // dd($request->all());
        $area = new DeliveryArea();

        $area->area_name = $request->area_name;
        $area->min_delivery_time = $request->min_delivery_time;
        $area->max_delivery_time = $request->max_delivery_time;
        $area->delivery_fee = $request->delivery_fee;
        $area->status = $request->status;
        $area->save();

        toastr()->success('Created Successfully');

        return to_route('admin.delivery-area.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deliveryArea = DeliveryArea::findOrFail($id);
        return view('admin.delivery-area.edit', compact('deliveryArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateDeliveryAreaRequest $request, string $id)
    {
        $deliveryArea = DeliveryArea::findOrFail($id);
        $deliveryArea->area_name = $request->area_name;
        $deliveryArea->min_delivery_time = $request->min_delivery_time;
        $deliveryArea->max_delivery_time = $request->max_delivery_time;
        $deliveryArea->delivery_fee = $request->delivery_fee;
        $deliveryArea->status = $request->status;
        $deliveryArea->save();
        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deliveryArea = DeliveryArea::findOrFail($id);
            // dd($whyChoseUs);
            $deliveryArea->delete();

            return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            logger($e);
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong'], 500);
        }
    }
}

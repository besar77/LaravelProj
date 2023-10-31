<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        return view("frontend.dashboard.index", compact('deliveryAreas', 'userAddresses'));
    }

    public function createAddress(AddressCreateRequest $request)
    {
        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->delivery_area_id;
        $address->firstName = $request->firstName;
        $address->lastName = $request->lastName;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();
        toastr()->success('Created Successfully');
        return redirect()->back();
    }
    public function updateAddress(string $id, AddressCreateRequest $request)
    {
        // dd($request->all());

        $address = Address::findOrFail($id);
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->delivery_area_id;
        $address->firstName = $request->firstName;
        $address->lastName = $request->lastName;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();
        toastr()->success('Updated Successfully');
        return to_route('dashboard');
    }

    public function deleteAddress(string $id)
    {
        try {
            $address = Address::findOrFail($id);
            if ($address && $address->user_id === auth()->user()->id) {
                $address->delete();
                return response()->json(['status' => 'success', 'message' => 'Address deleted successfully']);
            }
            return response()->json(['status' => 'error', 'message' => 'Something went wrong!'], 404);
        } catch (\Exception $e) {
            logger($e);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong!'], 404);
        }
    }
}

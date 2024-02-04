<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\SectionTitle;
use Illuminate\Http\Request;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyOfferDataTable $dataTable)
    {
        $titles = SectionTitle::where('key', 'like', '%daily_offer%')->get();
        // dd($titles);
        return $dataTable->render('admin.daily-offer.index', compact('titles'));
    }

    function prodSearch(Request $request){
        $product = Product::select('id','name','thumb_image')->where('name','like','%'.$request->search.'%')->get();

        return response($product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.daily-offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prod_id' => 'required|integer',
            'status' => 'boolean|required'
        ]);

        $offer = new DailyOffer();
        $offer->product_id = $request->prod_id;
        $offer->status = $request->status;
        $offer->save();

        toastr()->success('Offer Created Successfully');
        return to_route('admin.dailyOffers.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $dailyOffer = DailyOffer::with('product')->findOrFail($id);
        // dd($dailyOffer->product);
        return view('admin.daily-offer.edit',compact('dailyOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'prod_id' => 'required|integer',
            'status' => 'boolean|required'
        ]);

        $offer = DailyOffer::findOrFail($id);
        $offer->product_id = $request->prod_id;
        $offer->status = $request->status;
        $offer->save();

        toastr()->success('Updated Successfully');
        return to_route('admin.dailyOffers.index');
    }

    public function updateTitle(Request $request)
    {
       $validatedData = $request->validate([
            'daily_offer_top_title' => 'max:100',
            'daily_offer_main_title' => 'max:200',
            'daily_offer_sub_title' => 'max:300'
        ]);

        foreach($validatedData as $key => $v){
            SectionTitle::updateOrCreate(
                ['key' => $key],
                ['value' => $v]
            );
        }


        toastr()->success('Updated Succesfully');
        return redirect()->back();
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dailyOffer = DailyOffer::findOrFail($id);

            $dailyOffer->delete();
            return response()->json(['status' => 'success', 'message' => 'Daily Offer deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


}
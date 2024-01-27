<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use Illuminate\Http\Request;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyOfferDataTable $dataTable)
    {
        return $dataTable->render('admin.daily-offer.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
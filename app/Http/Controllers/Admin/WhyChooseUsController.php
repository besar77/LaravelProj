<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\WhyChooseUsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhyChooseUsCreateRequest;
use App\Models\SectionTitle;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WhyChooseUsDataTable $dataTable)
    {
        $titles = SectionTitle::where('key', 'like', '%why_choose%')->get();
        // dd($titles);
        return $dataTable->render('admin.why-choose-us.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.why-choose-us.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhyChooseUsCreateRequest $request)
    {
        WhyChooseUs::create($request->validated());

        toastr()->success('Created Succesfully');

        return to_route('admin.why-choose-us.index');
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
        $whyChoseUs = WhyChooseUs::findOrFail($id);

        return view('admin.why-choose-us.edit', compact('whyChoseUs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WhyChooseUsCreateRequest $request, string $id)
    {
        $whyChoseUs = WhyChooseUs::findOrFail($id);
        $whyChoseUs->update($request->validated());
        toastr()->success('Updated Succesfully');

        return to_route('admin.why-choose-us.index');
    }


    public function updateTitle(Request $request)
    {
        $request->validate([
            'why_choose_top_title' => 'max:100',
            'why_choose_main_title' => 'max:200',
            'why_choose_sub_title' => 'max:300'
        ]);

        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_top_title'],
            ['value' => $request->why_choose_top_title]
        );
        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_main_title'],
            ['value' => $request->why_choose_main_title]
        );
        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_sub_title'],
            ['value' => $request->why_choose_sub_title]
        );

        toastr()->success('Updated Succesfully');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $whyChoseUs = WhyChooseUs::findOrFail($id);
            // dd($whyChoseUs);
            $whyChoseUs->delete();

            return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong'], 500);
        }
    }
}

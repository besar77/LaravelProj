<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ChefDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChefCreateRequest;
use App\Http\Requests\Admin\UpdateChefRequest;
use App\Models\Chef;
use App\Models\SectionTitle;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ChefDataTable $datatable)
    {
        $titles = SectionTitle::where('key', 'like', '%chef%')->get();

        return $datatable->render('admin.chef.index',compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.chef.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChefCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request,'image');

        $chef = new Chef();
        $chef->image = $imagePath;
        $chef->name = $request->name;
        $chef->title = $request->title;
        $chef->fb = $request->fb;
        $chef->in = $request->in;
        $chef->x = $request->x;
        $chef->web = $request->web;
        $chef->status = $request->status;
        $chef->show_at_home = $request->show_at_home;
        $chef->save();

        toastr()->success('Chef Added Successfully');

        return to_route('admin.chef.index');

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $chef = Chef::findOrFail($id);
        // dd($chef);
        return view('admin.chef.edit',compact('chef'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChefRequest $request, string $id)
    {
        $imagePath = $this->uploadImage($request,'image',$request->old_image);

        $chef = Chef::findOrFail($id);
        $chef->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $chef->name = $request->name;
        $chef->title = $request->title;
        $chef->fb = $request->fb;
        $chef->in = $request->in;
        $chef->x = $request->x;
        $chef->web = $request->web;
        $chef->status = $request->status;
        $chef->show_at_home = $request->show_at_home;
        $chef->save();

        toastr()->success('Chef ' . $request->name . ' Updated Successfully');

        return to_route('admin.chef.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $chef = Chef::findOrFail($id);
            $this->removeImage($chef->image);
            // dd($whyChoseUs);
            $chef->delete();

            return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong'], 500);
        }
    }

    public function updateTitle(Request $request)
    {
       $validatedData = $request->validate([
            'chef_top_title' => 'max:100',
            'chef_main_title' => 'max:200',
            'chef_sub_title' => 'max:300'
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
}
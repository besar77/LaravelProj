<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerSliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerSliderCreateRequest;
use App\Http\Requests\Admin\UpdateBannerSliderRequest;
use App\Models\BannerSlider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BannerSliderController extends Controller
{
    use FileUploadTrait;
    public function index(BannerSliderDataTable $dataTable){

        return $dataTable->render('admin.banner-slider.index');

    }

    public function create(Request $request){
        return view('admin.banner-slider.create');
    }

    public function store(BannerSliderCreateRequest $request){

        $imagePath = $this->uploadImage($request,'image');

        $bannerSlider = new BannerSlider();
        $bannerSlider->banner = $imagePath;
        $bannerSlider->title = $request->title;
        $bannerSlider->subTitle = $request->subtitle;
        $bannerSlider->url = $request->url;
        $bannerSlider->status = $request->status;

        $bannerSlider->save();

        toastr()->success('Banner Slider Created Successfully');
        return to_route('admin.bannerSlider.index');

    }

    public function edit(string $id){

        $bannerSlider = BannerSlider::findOrFail($id);

        return view('admin.banner-slider.edit',compact('bannerSlider'));
    }

    public function update(UpdateBannerSliderRequest $request, string $id){

        $imagePath = $this->uploadImage($request,'image', $request->old_image);

        $bannerSlider = BannerSlider::findOrFail($id);
        $bannerSlider->banner = !empty($imagePath) ? $imagePath : $request->old_image;
        $bannerSlider->title = $request->title;
        $bannerSlider->subTitle = $request->subtitle;
        $bannerSlider->url = $request->url;
        $bannerSlider->status = $request->status;

        $bannerSlider->save();

        toastr()->success('Banner Slider Updated Successfully');
        return to_route('admin.bannerSlider.index');

    }

    public function destroy(string $id)
    {
        try {
            $banner = BannerSlider::findOrFail($id);
            $this->removeImage($banner->banner);
            $banner->delete();

            return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong'], 500);
        }
    }
}
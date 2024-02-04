<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppDownloadSectionRequest;
use App\Models\AppDownloadSection;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class AppDownloadSectionController extends Controller
{

    use FileUploadTrait;

    public function index(){

        $res = AppDownloadSection::first();
        // dd($res);
        return view('admin.app-download-section.index', compact('res'));
    }

    public function store(AppDownloadSectionRequest $request){

        // dd($request->apple_store_link);

        $imagePath = $this->uploadImage($request,'image');
        $backgroundPath = $this->uploadImage($request,'background');

        AppDownloadSection::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ? $imagePath : '',
                'background' => !empty($backgroundPath) ? $backgroundPath : '',
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'app_store_link' => $request->apple_store_link
            ]
            );

        toastr()->success('Successfully');

        return to_route('admin.app-download.index');

    }
}
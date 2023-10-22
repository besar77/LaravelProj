<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return view("admin.profile.index");
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {

        $user = Auth::user();

        $imagePath = $this->uploadImage($request, 'avatar');
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = isset($imagePath) ? $imagePath : $user->avatar;
        $user->save();

        toastr()->success("Updates succesfully");
        return redirect()->back();
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request)
    {

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr()->success("Password updated Succesfully");
        return  redirect()->back();
    }
}

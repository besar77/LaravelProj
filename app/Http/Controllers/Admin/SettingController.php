<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\View\View;


class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all();

        return view('admin.setting.index');
    }

    public function UpdateGeneralSetting(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|max:255',
            'site_default_currency' => 'required|max:10',
            'site_currency_icon' => 'required|max:10',
            'site_currency_icon_position' => 'required|max:255',
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key,],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    public function updatePusherSetting(Request $request)
    {
        $validatedData = $request->validate([
            'pusher_app_id' => 'required',
            'pusher_key' => 'required',
            'pusher_secret' => 'required',
            'pusher_cluster' => 'required',
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key,],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}

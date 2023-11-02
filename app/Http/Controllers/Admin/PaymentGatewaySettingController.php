<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PaymentGatewaySettingController extends Controller
{

    use FileUploadTrait;

    public function index()
    {
        $paymentGateway = PaymentGatewaySetting::pluck('value', 'key')->all();
        // dd($paymentGateway);

        return view('admin.payment-setting.index', compact('paymentGateway'));
    }

    public function paypalSettingUpdate(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'paypal_status' => 'required|boolean',
            'paypal_account_mode' => 'required|in:sandbox,live',
            'paypal_country' => 'required',
            'paypal_currency' => 'required',
            'paypal_rate' => 'required|numeric',
            'paypal_api_key' => 'required',
            'paypal_secret_key' => 'required',
            'paypal_app_id' => 'required',
        ]);

        // dd('Para pikes');

        if ($request->hasFile('paypal_logo')) {
            // dd('A jemi ne pike');
            $request->validate([
                'paypal_logo' => 'nullable|image'
            ]);

            $imagePath = $this->uploadImage($request, 'paypal_logo');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'paypal_logo'],
                ['value' => $imagePath]
            );
        }


        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    public function stripeSettingUpdate(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'stripe_status' => 'required|boolean',
            'stripe_country' => 'required',
            'stripe_currency' => 'required',
            'stripe_rate' => 'required|numeric',
            'stripe_api_key' => 'required',
            'stripe_secret_key' => 'required',
        ]);

        // dd('Para pikes');

        if ($request->hasFile('stripe_logo')) {
            // dd('A jemi ne pike');
            $request->validate([
                'stripe_logo' => 'nullable|image'
            ]);

            $imagePath = $this->uploadImage($request, 'stripe_logo');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'stripe_logo'],
                ['value' => $imagePath]
            );
        }


        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}

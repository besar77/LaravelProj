<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\Frontend\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    //Profile routes
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    //Slider routes
    Route::resource('slider', SliderController::class);

    //Why choose us routes
    Route::put('why-choose-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-title.update');

    Route::resource('why-choose-us', WhyChooseUsController::class); //resource routes duhet ne fund me i vendos nese kemi routes tjera ne ate kontroller


    //Product category Resource
    Route::resource('category', CategoryController::class);


    //Product resource
    Route::resource('product', ProductController::class);

    //Product gallery photo
    Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
    Route::resource('product-gallery', ProductGalleryController::class);

    //Porudct size
    Route::get('product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size.show-index');
    Route::resource('product-size', ProductSizeController::class);
    //Product options
    Route::resource('product-option', ProductOptionController::class);

    //Coupon Routes
    Route::resource('coupon', CouponController::class);



    //Delivery Areas Routes
    Route::resource('delivery-area', DeliveryAreaController::class);

    //Order Routes
    Route::get('orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('pending-orders', [OrderController::class, 'pendingOrdersIndex'])->name('pending-orders');
    Route::get('in-process-orders', [OrderController::class, 'inProcessOrdersIndex'])->name('in-process-orders');
    Route::get('declined-orders', [OrderController::class, 'declinedOrdersIndex'])->name('declined-orders');
    Route::get('delivered-orders', [OrderController::class, 'deliveredOrdersIndex'])->name('delivered-orders');

    Route::get('order/status-update/{id}', [OrderController::class, 'getOrderStatus'])->name('orders.status');
    Route::put('order/status-update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('orders.status-update');


    //Payment Gateway Settings
    Route::get('/payment-gateway-settings', [PaymentGatewaySettingController::class, 'index'])->name('payment-setting.index');
    Route::put('/paypal-setting', [PaymentGatewaySettingController::class, 'paypalSettingUpdate'])->name('paypal-setting.update');
    Route::put('/stripe-setting', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe-setting.update');

    //Notification Routes
    Route::get('clear-notification', [AdminDashboardController::class, 'clearNotification'])->name('clear-notification');



    //Messages Routes
    Route::get('chat', [ChatController::class, 'index'])->name('chat-index');
    Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');

    //Settings
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
    Route::put('/pusher-setting', [SettingController::class, 'updatePusherSetting'])->name('pusher-setting.update');


    //Daily Offer Routes
    Route::get('dailyOffer/search-product',[DailyOfferController::class,'prodSearch'])->name('dailyOffer.searchProduct');
    Route::put('dailyOffer/title-update', [DailyOfferController::class, 'updateTitle'])->name('dailyOffer-title.update');
    Route::resource('dailyOffers',DailyOfferController::class);


    //Banner Slider Routes
    Route::resource('bannerSlider',BannerSliderController::class);

    //Chef Routes
    Route::put('chef/title-update', [ChefController::class, 'updateTitle'])->name('chef-title.update');
    Route::resource('chef',ChefController::class);

});

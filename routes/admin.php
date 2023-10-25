<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
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
});

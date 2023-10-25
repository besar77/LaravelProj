<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {

        $sectionTitles = $this->getSectionTitles();
        $sliders = Slider::where("status", 1)->get();
        $whyChooseUs = WhyChooseUs::where("status", 1)->get();
        return view('frontend.home.index', compact('sliders', 'sectionTitles', 'whyChooseUs'));
    }

    function getSectionTitles(): Collection
    {
        return SectionTitle::where('key', 'like', '%why_choose%')->get();
    }
}

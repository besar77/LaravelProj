<section class="fp__why_choose mt_100 xs_mt_70">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_25">
                    <h4>{!! @$sectionTitles->firstWhere('key', 'why_choose_top_title')->value !!}</h4>
                    <h2>{!! @$sectionTitles->firstWhere('key', 'why_choose_main_title')->value !!}</h2>
                    <span>
                        <img src="{{ asset('frontend/images/heading_shapes.png') }}" alt="shapes"
                            class="img-fluid w-100">
                    </span>
                    <p>{!! @$sectionTitles->firstWhere('key', 'why_choose_sub_title')->value !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($whyChooseUs as $w)
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="fp__choose_single">
                        <div class="icon icon_1">
                            <i class="{{ $w->icon }}"></i>
                        </div>
                        <div class="text">
                            <h3>{!! $w->title !!}</h3>
                            <p>{!! $w->short_description !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

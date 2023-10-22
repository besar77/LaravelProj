@extends('frontend.layouts.master')


@section('content')


@include('frontend.home.components.slider')

<!--=============================
    BANNER END
==============================-->


<!--=============================
    WHY CHOOSE START
==============================-->
@include('frontend.home.components.whyChoose')
<!--=============================
    WHY CHOOSE END
==============================-->


<!--=============================
    OFFER ITEM START
==============================-->
@include('frontend.home.components.offerItem')

<!-- CART POPUT START -->
@include('frontend.home.components.cartPopup')
<!-- CART POPUT END -->
<!--=============================
    OFFER ITEM END
==============================-->


<!--=============================
    MENU ITEM START
==============================-->
@include('frontend.home.components.menuItem')
<!--=============================
    MENU ITEM END
==============================-->


<!--=============================
    ADD SLIDER START
==============================-->
@include('frontend.home.components.addSlider')
<!--=============================
    ADD SLIDER END
==============================-->


<!--=============================
    TEAM START
==============================-->
@include('frontend.home.components.team')
<!--=============================
    TEAM END
==============================-->


<!--=============================
    DOWNLOAD APP START
==============================-->
@include('frontend.home.components.downloadApp')
<!--=============================
    DOWNLOAD APP END
==============================-->


<!--=============================
   TESTIMONIAL  START
==============================-->
@include('frontend.home.components.testimonial')
<!--=============================
    TESTIMONIAL END
==============================-->


<!--=============================
    COUNTER START
==============================-->
@include('frontend.home.components.counter')
<!--=============================
    COUNTER END
==============================-->


<!--=============================
    BLOG 2 START
==============================-->
@include('frontend.home.components.blog')
<!--=============================
    BLOG 2 END
==============================-->

@endsection

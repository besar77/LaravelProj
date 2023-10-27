@extends('frontend.layouts.master')
@section('content')
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              BREADCRUMB START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>menu Details</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">home</a></li>
                        <li><a href="javascript:;">menu Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ==============================-->


    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                MENU DETAILS START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                <li><img class="zoom ing-fluid w-100" src="{{ asset($product->thumb_image) }}"
                                        alt="{{ $product->name }}"></li>

                                {{-- @dd($product->productImages) --}}

                                @foreach ($product->productImages as $i)
                                    <li><img class="zoom ing-fluid w-100" src="{{ asset($i->image) }}"
                                            alt="{{ $product->name }}"></li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{!! $product->name !!}</h2>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(201)</span>
                        </p>
                        <h3 class="price">

                            @if ($product->offer_price && $product->offer_price < $product->price)
                                {{ currencyPosition($product->offer_price) }}<del>{{ currencyPosition($product->price) }}</del>
                            @else
                                {{ currencyPosition($product->price) }}
                            @endif
                        </h3>
                        <p class="short_description">
                            {!! $product->short_description !!}
                        </p>

                        <form action="" id="v_add_to_cart_form">
                            @csrf
                            <input type="hidden" name="v_base_price" class="v_base_price"
                                value={{ $product->offer_price > 0 ? $product->offer_price : $product->price }}>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            @if ($product->productSizes()->exists())
                                <div class="details_size">
                                    <h5>select size</h5>

                                    @foreach ($product->productSizes as $sizes)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_size" type="radio"
                                                name="product_size" id="{{ $sizes->name }}"
                                                data-price="{{ $sizes->price }}" value={{ $sizes->id }}>
                                            <label class="form-check-label" for="{{ $sizes->name }}">
                                                {!! $sizes->name !!} <span>+
                                                    {{ currencyPosition($sizes->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($product->productOptions()->exists())
                                <div class="details_extra_item">
                                    <h5>select option <span>(optional)</span></h5>
                                    @foreach ($product->productOptions as $options)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_option" type="checkbox" value=""
                                                name="product_option[]" id="{{ $options->name }}"
                                                data-price="{{ $options->price }}" value={{ $options->id }}>
                                            <label class="form-check-label" for="{{ $options->name }}">
                                                {!! $options->name !!} <span>+
                                                    {{ currencyPosition($options->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif



                            <div class="details_quentity">
                                <h5>select quentity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger v_decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" name="quantity" id="v_quantity" placeholder="1" value="1"
                                            readonly>
                                        <button class="btn btn-success v_increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <h3 id="v_total_price">
                                        {{ $product->offer_price > 0 ? currencyPosition($product->offer_price) : currencyPosition($product->price) }}
                                    </h3>
                                </div>
                            </div>

                        </form>



                        <ul class="details_button_area d-flex flex-wrap">
                            @if ($product->quantity === 0)
                            <li><a class="common_btn bg-danger pe-none" href="javascript:;">Stock Out</a></li>
                                @else
                                <li><a class="common_btn v_submit_button" href="#">add to cart</a></li>
                            @endif
                            <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">

                                    {!! $product->long_description !!}

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="fp__review_area">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4>04 reviews</h4>
                                            <div class="fp__comment pt-0 mt_20">
                                                <div class="fp__single_comment m-0 border-0">
                                                    <img src="images/comment_img_1.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>Michel Holder <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/chef_1.jpg" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>salina khan <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/comment_img_2.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>Mouna Sthesia <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/chef_3.jpg" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>marjan janifar <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="load_more">load More</a>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fp__post_review">
                                                <h4>write a Review</h4>
                                                <form>
                                                    <p class="rating">
                                                        <span>select your rating : </span>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <input type="text" placeholder="Name">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <input type="email" placeholder="Email">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <textarea rows="3" placeholder="Write your review"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @if (count($relatedProducts) > 0)
                <div class="fp__related_menu mt_90 xs_mt_60">
                    <h2>related item</h2>
                    <div class="row related_product_slider">

                        @foreach ($relatedProducts as $related)
                            <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{ asset($related->thumb_image) }}" alt="menu"
                                            class="img-fluid w-100">
                                        <a class="category" href="#">{!! $related->category->name !!}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                        <p class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <span>74</span>
                                        </p>
                                        <a class="title"
                                            href="{{ route('product.show', $related->slug) }}">{{ $related->name }}</a>
                                        <h5 class="price">
                                            @if ($related->offer_price && $related->offer_price < $related->price)
                                                {{ currencyPosition($related->offer_price) }}
                                                <del>{{ currencyPosition($related->price) }}</del>
                                            @else
                                                {{ currencyPosition($related->price) }}
                                            @endif

                                        </h5>
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="javascript:;"
                                                    onclick="loadProductModal('{{ $related->id }}')"><i
                                                        class="fas fa-shopping-basket"></i></a></li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif


        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.v_product_size').on('change', function() {
                v_updateTotalPrice();

            });

            $('.v_product_option').on('change', function() {
                v_updateTotalPrice();
            });
        });

        //Event handler for increment and decrement buttons
        $('.v_increment').on('click', function(e) {
            e.preventDefault();

            let quantity = $('#v_quantity');
            let currentQuantity = parseFloat(quantity.val());
            quantity.val(currentQuantity + 1);
            v_updateTotalPrice();
        });

        $('.v_decrement').on('click', function(e) {
            e.preventDefault();

            let quantity = $('#v_quantity');
            let currentQuantity = parseFloat(quantity.val());
            if (currentQuantity > 1) {
                quantity.val(currentQuantity - 1);
            }
            v_updateTotalPrice();

        });

        //Function to update total price based on selected options
        function v_updateTotalPrice() {
            let basePrice = parseFloat($('.v_base_price').val());
            let selectedSizePrice = 0;
            let selectedOptionsPrice = 0;
            let quantity = parseFloat($('#v_quantity').val());


            //Calculate size price selected
            let selectedSize = $(
                '.v_product_size:checked'
            ); //e kemi qit :checked per me kontrollu se cili button eshte i chekun se jo me ja marr vleren e secilit
            if (selectedSize.length > 0) {
                selectedSizePrice = parseFloat(selectedSize.data("price"));
            }

            //Calculate options price
            let selectedOptions = $('.v_product_option:checked');
            $(selectedOptions).each(function() {
                selectedOptionsPrice += parseFloat($(this).data("price"));
            })



            //Shuma totale
            let totalPrice = (basePrice + selectedOptionsPrice + selectedSizePrice) * quantity;
            totalPrice = totalPrice.toFixed(2);
            $('#v_total_price').text("{{ config('settings.site_currency_icon') }}" + totalPrice);
        }

        $('.v_submit_button').on('click', function(e) {
            e.preventDefault();
            $('#v_add_to_cart_form').submit();

        });

        //Add to cart function
        $('#v_add_to_cart_form').on('submit', function(e) {
            e.preventDefault();

            //Validation
            let selectedSize = $('.v_product_size');
            if (selectedSize.length > 0) {
                if ($('.v_product_size:checked').val() === undefined) {
                    toastr.error('Please select a size');
                    console.log('select size');
                    return;
                }
            }
            let quantity = $('#v_quantity').val();
            let formData = $(this).serialize();

            // Manually append the quantity to the serialized data
            formData += "&quantity=" + quantity;

            $.ajax({
                method: "POST",
                url: '{{ route('add-to-cart') }}',
                data: formData,
                beforeSend: function() {
                    $('.v_submit_button').attr('disabled', 'true');
                    $('.v_submit_button').html(
                        `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>`
                    );
                },
                success: function(response) {
                    updateSidebarCart();
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    let errorMsg = xhr.responseJSON.message;
                    toastr.error(errorMsg);
                },
                complete: function() {
                    $('.v_submit_button').removeAttr('disabled');
                    $('.v_submit_button').html(
                        'Add to cart'
                    );
                },
            });
        })
    </script>
@endpush

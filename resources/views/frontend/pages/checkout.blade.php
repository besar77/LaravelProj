@extends('frontend.layouts.master')
@section('content')
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    BREADCRUMB START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>checkout</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    BREADCRUMB END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->


    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    CHECK OUT PAGE START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__checkout_form">
                        <div class="fp__check_form">
                            <h5>select address <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i
                                        class="far fa-plus"></i> add address</a></h5>

                            {{-- add new address modal --}}
                            <div class="fp__address_modal">
                                <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="address_modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="address_modalLabel">add new address
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fp_dashboard_new_address d-block">
                                                    <form action="{{ route('address.store') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4>add new address</h4>
                                                            </div>
                                                            @if (count($deliveryAreas) > 0)
                                                                <div class="col-md-12 col-lg-12 col-xl-12">
                                                                    <div class="fp__check_single_form">
                                                                        <select id="select_js3" name="delivery_area_id">
                                                                            <option value="">select area</option>
                                                                            @foreach ($deliveryAreas as $area)
                                                                                <option value="{{ $area->id }}">
                                                                                    {!! $area->area_name !!}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="First Name"
                                                                        name="firstName">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="Last Name"
                                                                        name="lastName">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="Phone"
                                                                        name="phone">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="Email"
                                                                        name="email">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <textarea cols="3" rows="4" placeholder="Address" name="address"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="fp__check_single_form check_area">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="flexRadioDefault1" name="type"
                                                                            value="home">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault1">
                                                                            home
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="flexRadioDefault2" name="type"
                                                                            value="office">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault2">
                                                                            office
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex" style="gap:40px;">
                                                                <button type="button" class="common_btn cancel_new_address"
                                                                    data-bs-dismiss="modal">cancel</button>
                                                                <button type="submit" class="common_btn">save
                                                                    address</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- select address --}}
                            <div class="row">
                                @foreach ($userAddresses as $a)
                                    <div class="col-md-6">
                                        <div class="fp__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input v_address" type="radio" name="type"
                                                    id="{{ $a->id }}" value={{ $a->id }}>
                                                <label class="form-check-label" for="{{ $a->id }}">
                                                    <span class="icon">
                                                        @if ($a->type === 'home')
                                                            <i class="fas fa-home"></i> home
                                                        @else
                                                            <i class="far fa-car-building"></i>office
                                                        @endif

                                                    </span>
                                                    <span
                                                        class="address">{{ $a->address }},{{ $a->deliveryArea->area_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span>{{ currencyPosition(cartTotal()) }}</span></p>
                        <p>delivery: <span id="delivery_fee">$0.00</span></p>
                        @if (session()->has('coupon'))
                            <p>discount: <span>{{ currencyPosition(session()->get('coupon')['discount']) }}</span></p>
                        @else
                            <p>discount: <span>{{ currencyPosition(0) }}</span></p>
                        @endif
                        <p class="total"><span>total:</span> <span
                                id="grand_total">{{ currencyPosition(grandCartTotal()) }}</span></p>
                        <a class="common_btn" href=" #">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    CHECK OUT PAGE END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // $('.v_address').prop('checked', false);
            $('.v_address').on('click', function() {
                let addressId = $(this).val();
                let deliveryFee = $('#delivery_fee');
                let subTotal = $('#grand_total');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('checkout.delivery-calc') }}',
                    data: {
                        addressId: addressId
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        let deliveryAmount = response.delivery_fee;
                        let total = response.grand_total;
                        deliveryFee.text("{{ currencyPosition(':fee') }}".replace(':fee',
                            deliveryAmount));
                        subTotal.text("{{ currencyPosition(':total') }}".replace(':total',
                            total));
                    },
                    error: function(xhr, status, error) {
                        let errMsg = xhr.responseJSON.message;
                        toastr.error(errMsg);
                    },
                    complete: function() {
                        hideLoader();
                    },
                })
            });
        });
    </script>
@endpush

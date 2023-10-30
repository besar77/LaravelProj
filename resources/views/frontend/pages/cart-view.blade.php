@extends('frontend.layouts.master')
@section('content')
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    BREADCRUMB START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    BREADCRUMB END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->


    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    CART VIEW START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table id="productTable">
                                <tbody>
                                    <tr>
                                        <th class="fp__pro_img">
                                            Image
                                        </th>

                                        <th class="fp__pro_name">
                                            details
                                        </th>

                                        <th class="fp__pro_status">
                                            price
                                        </th>

                                        <th class="fp__pro_select">
                                            quantity
                                        </th>

                                        <th class="fp__pro_tk">
                                            total
                                        </th>

                                        <th class="fp__pro_icon">
                                            <a class="clear_all" href="javascript:;">clear all</a>
                                        </th>
                                    </tr>

                                    {{-- Products --}}
                                    @foreach (Cart::content() as $product)
                                        <tr>
                                            <td class="fp__pro_img"><img
                                                    src="{{ asset($product->options->product_info['image']) }}"
                                                    alt="product" class="img-fluid w-100">
                                            </td>

                                            <td class="fp__pro_name">
                                                <a
                                                    href="{{ route('product.show', $product->options->product_info['slug']) }}">{!! $product->name !!}</a>
                                                <span>{{ @$product->options->product_size[0]['name'] }}{{ @$product->options->product_size[0]['price'] ? ': ' . currencyPosition(@$product->options->product_size[0]['price']) : '' }}</span>
                                                @foreach (@$product->options->product_options as $options)
                                                    <p>{{ $options['name'] }}: {{ currencyPosition($options['price']) }}</p>
                                                @endforeach
                                            </td>

                                            <td class="fp__pro_status">
                                                <h6>{{ currencyPosition($product->price) }}</h6>
                                            </td>

                                            <td class="fp__pro_select">
                                                <div class="quentity_btn">
                                                    {{-- <input type="hidden" id="quantity_max" value="{{ $product->qty }}"> --}}
                                                    <button class="btn btn-danger decrement"><i
                                                            class="fal fa-minus"></i></button>
                                                    <input type="text" placeholder="1" value="{{ $product->qty }}"
                                                        name="quantity" data-id="{{ $product->rowId }}" class="quantity"
                                                        readonly>
                                                    <button class="btn btn-success increment"><i
                                                            class="fal fa-plus"></i></button>
                                                </div>
                                            </td>

                                            <td class="fp__pro_tk">
                                                <h6 id="h6_total_price_single_prod-{{ $product->rowId }}">
                                                    {{ currencyPosition(productTotal($product->rowId)) }}</h6>
                                            </td>

                                            <td class="fp__pro_icon">
                                                <a href="javascript:;" class="remove_cart_product"
                                                    data-id="{{ $product->rowId }}"><i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (Cart::content()->count() > 0)
                                        <tr class="d-none" id="cart_empty_td">
                                        @elseif(Cart::content()->count() === 0)
                                        <tr>
                                    @endif
                                    <td colspan="6" class="text-center" style="width: 100%; display:inline;">Cart is
                                        empty</td>
                                    </tr>






                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="subtotal">{{ currencyPosition(cartTotal()) }}</span></p>
                        <p>delivery: <span>{{ config('settings.site_currency_icon') }}0.00</span></p>
                        <p>discount: <span id="discount">
                                @if (isset(session()->get('coupon')['discount']))
                                    {{ config('settings.site_currency_icon') }}{{ session()->get('coupon')['discount'] }}
                                @else
                                    {{ config('settings.site_currency_icon') }}0.00
                                @endif

                            </span></p>
                        <p class="total"><span>total:</span> <span id="final_total">
                                @if (isset(session()->get('coupon')['discount']))
                                    {{ config('settings.site_currency_icon') }}{{ cartTotal() - session()->get('coupon')['discount'] }}
                                @else
                                    {{ config('settings.site_currency_icon') }}{{ cartTotal() }}
                                @endif
                            </span></p>
                        <form id="coupon_form">
                            <input type="text" id="coupone_code" name="code" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>

                        <div class="coupon_card">
                            @if (session()->has('coupon'))
                                <div class="card mt-2">
                                    <div class="m-3">
                                        <span><b class="v_coupon_code">Applied Coupon:
                                                {{ session()->get('coupon')['code'] }}</b></span>
                                        <span>
                                            <button id="v_delete_coupon_code"><i class="far fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <a class="common_btn" href=" #">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    CART VIEW END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            var cartTotal = parseFloat("{{ cartTotal() }}");
            console.log(cartTotal);

            $('.increment').on('click', function(e) {
                // console.log("Click event triggered.");
                let inputField = $(this).siblings('.quantity');
                let currentValue = parseInt(inputField.val());
                let rowId = inputField.data('id');
                inputField.val(currentValue + 1);
                // console.log(inputField.val());
                // console.log("Before calling cartQtyUpdate with rowId:", rowId, "qty:", inputField.val());
                cartQtyUpdate(rowId, inputField.val(), function(response) {
                    console.log(response);

                    if (response.status === 'success') {
                        inputField.val(response.qty);
                        let totalProdAmount = response.product_total.toFixed(2);
                        $('#h6_total_price_single_prod-' + rowId).text(
                            "{{ currencyPosition(':totalProdAmount') }}".replace(
                                ':totalProdAmount', totalProdAmount));

                        cartTotal = response.cart_total;
                        $('#subtotal').text(cartTotal);
                        let grandCartTotal = response.grandCartTotal.toFixed(2);
                        $('#final_total').text("{{ config('settings.site_currency_icon') }}" +
                            grandCartTotal);

                    } else if (response.status === 'error') {
                        inputField.val(response.qty);
                        toastr.error(response.message);
                    }
                });

            });

            $('.decrement').on('click', function(e) {
                let inputField = $(this).siblings('.quantity');
                let currentValue = parseInt(inputField.val());
                let rowId = inputField.data('id');


                if (currentValue > 1) {
                    inputField.val(currentValue - 1);
                    cartQtyUpdate(rowId, inputField.val(), function(response) {

                        if (response.status === 'success') {
                            inputField.val(response.qty);
                            let totalProdAmount = response.product_total.toFixed(2);
                            $('#h6_total_price_single_prod-' + rowId).text(
                                "{{ currencyPosition(':totalProdAmount') }}".replace(
                                    ':totalProdAmount', totalProdAmount));

                            cartTotal = response.cart_total;
                            $('#subtotal').text(cartTotal);
                            let grandCartTotal = response.grandCartTotal.toFixed(2);
                            $('#final_total').text("{{ config('settings.site_currency_icon') }}" +
                                grandCartTotal);

                        } else if (response.status === 'error') {
                            inputField.val(response.qty);
                            toastr.error(response.message);
                        }
                    });
                }
            });

            function cartQtyUpdate(rowId, qty, callback) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('cart.quantity-update') }}",
                    data: {
                        'rowId': rowId,
                        'qty': qty
                    },

                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {

                        if (callback && typeof callback === 'function') {
                            callback(response);
                        }

                    },
                    error: function(xhr, status, error) {
                        let errorMsg = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        hideLoader();
                    }
                });
            }

            $('.remove_cart_product').on('click', function(e) {
                e.preventDefault();
                let rowId = $(this).data('id');
                removeCartProduct(rowId);
                $(this).closest('tr').remove();
            });

            function removeCartProduct(rowId) {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('cart-product-remove', 'rowId') }}'.replace("rowId", rowId),
                    data: {
                        'rowId': rowId,
                    },

                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        updateSidebarCart();
                        cartTotal = response.cart_total;
                        $('#subtotal').text(cartTotal);
                        let grandCartTotal = response.grandCartTotal.toFixed(2);
                        $('#final_total').text("{{ config('settings.site_currency_icon') }}" +
                            grandCartTotal);
                    },
                    error: function(xh, status, error) {
                        console.error(error);
                    },
                    complete: function() {
                        hideLoader();
                    }
                });
            }

            $('.clear_all').on('click', function() {
                removeAllProdsFromCart();
                $('#productTable tr:not(:has(.clear_all))').remove();
            });


            function removeAllProdsFromCart() {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('cart-products-all-remove') }}',

                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        updateSidebarCart();
                        $('#cart_empty_td').removeClass = ('d-none');
                        // console.log(response);
                        cartTotal = response.cart_total;
                        $('#subtotal').text(cartTotal);
                        let grandCartTotal = response.grandCartTotal.toFixed(2);
                        $('#final_total').text("{{ config('settings.site_currency_icon') }}" +
                            grandCartTotal);
                        $('#discount').text("{{ config('settings.site_currency_icon') }}" + 0.00);

                    },
                    error: function(xh, status, error) {
                        console.error(error);
                    },
                    complete: function() {
                        hideLoader();
                    }
                });
            }

            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();

                let code = $('#coupone_code').val();
                let subTotal = cartTotal;
                console.log(subTotal);

                couponApply(code, subTotal);

            });

            // function updateSubtotal() {
            //     console.log('a jemi ne pike');
            //     $('#subtotal').text("{{ config('settings.site_currency_icon') }}" + getCartTotal());
            //     console.log(getCartTotal());
            // }

            function couponApply(code, subTotal) {

                $.ajax({
                    method: 'POST',
                    url: "{{ route('apply-coupon') }}",
                    data: {
                        code: code,
                        subTotal: subTotal
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        $('#discount').text("{{ config('settings.site_currency_icon') }}" + response
                            .discount);
                        $('#final_total').text("{{ config('settings.site_currency_icon') }}" + response
                            .finalTotal);

                        let couponCartHTML = `<div class="card mt-2">
                                    <div class="m-3">
                                        <span><b class="v_coupon_code">Applied Coupon: ${response.coupon_code}</b></span>
                                        <span>
                                            <button id="v_delete_coupon_code"><i class="far fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>`;
                        $('.coupon_card').html(couponCartHTML);
                        $('#coupone_code').val('');
                        toastr.success(response.message);

                    },
                    error: function(xhr, status, error) {
                        let errorMsg = xhr.responseJSON.message;
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        hideLoader();
                    }
                })

            }

            $(document).on('click', '#v_delete_coupon_code', function() {
                destroyCoupon();
            });

            function destroyCoupon() {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('destroy-coupon') }}',
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        let discount = '0.00';
                        $('#discount').text("{{ config('settings.site_currency_icon') }}" + discount);
                        let grandTotal = response.grandCartTotal.toFixed(2);
                        $('#final_total').text("{{ config('settings.site_currency_icon') }}" +
                            grandTotal);
                        $('.coupon_card').html("");

                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        hideLoader();
                    }
                })
            }



        });
    </script>
@endpush

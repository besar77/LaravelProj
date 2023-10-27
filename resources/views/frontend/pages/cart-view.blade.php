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
                        <p>subtotal: <span>{{ currencyPosition(cartTotal()) }}</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span>$10.00</span></p>
                        <p class="total"><span>total:</span> <span>$134.00</span></p>
                        <form id="coupon_form">
                            <input type="text" id="coupone_code" name="code" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>
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
                        // $('#span_cart_sub_total').text("{{ cartTotal() }}");
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
                let subTotal = getCartTotal();
                // console.log(subTotal);

                couponApply(code, subTotal);

            });


            function couponApply(code, subTotal) {

                $.ajax({
                    method: 'GET',
                    url: "{{ route('apply-coupon') }}",
                    data: {
                        code: code,
                        subTotal: subTotal
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {

                    },
                    complete: function() {

                    }
                })

            }


        });
    </script>
@endpush

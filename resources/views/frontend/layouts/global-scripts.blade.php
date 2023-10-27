<script>
    function loadProductModal(productId) {

        $.ajax({
            type: "GET",
            url: '{{ route('load-product-modal', ':productId') }}'.replace(':productId', productId),
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
            },
            success: function(response) {

                $('.load_product_modal_body').html(response);
                $('#cartModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log(error);
            },
            complete: function() {
                $('.overlay').removeClass('active');
                $('.overlay-container').addClass('d-none');
            }
        });

    }

    //Update Sidebar cart
    function updateSidebarCart(callBack = null) {

        $.ajax({
            type: "GET",
            url: '{{ route('get-cart-products') }}',
            success: function(response) {
                $('.cart_contents').html(response);

                let cartCount = $('#cart_product_count').val();
                $('#cart_total_h5_id').text('Total Item (' + cartCount + ')');
                $('#cart_total_h5_id').text('Total Item (' + cartCount + ')');
                $('#cart_count_span_id').text(cartCount);

                let cartTotal = $('#cart_total_id').val();
                $('.cart_total_class').text("{{ currencyPosition(':cartTotal') }}".replace(':cartTotal',
                    cartTotal));

                if (callBack && typeof callBack === 'function') {
                    callBack();
                }

            },
            error: function(xhr, status, error) {
                console.log(error);
            },
        });
    }

    //remove cart product from sidebar
    function removeProductFromSidebar(rowId) {
        $.ajax({
            method: 'GET',
            url: '{{ route('cart-product-remove', ':rowId') }}'.replace(':rowId', rowId),
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
            },
            success: function(response) {
                if (response.status === 'success') {
                    updateSidebarCart(function() {
                        toastr.success(response.message);
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    })

                }
            },
            error: function(xhr, status, error) {
                let errorMsg = xhr.responseJSON.message;
                toastr.error(errorMsg);
            },
        });
    }

    //Hide show overlay loader
    function showLoader() {
        $('.overlay-container').removeClass('d-none');
        $('.overlay').addClass('active');
    }

    function hideLoader() {
        $('.overlay').removeClass('active');
        $('.overlay-container').addClass('d-none');
    }

    //Get current total amount of cart
    function getCartTotal() {
        // console.log("{{ cartTotal() }}")
        return parseFloat("{{ cartTotal() }}");
    }
</script>

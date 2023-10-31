<script>
    $('body').on('click', '.delete-item', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        console.log(url);

        let classToDelete = $(this).closest('.col-md-6');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        if (response.status === 'success') {

                            // rowToDelete.remove();
                            classToDelete.remove();

                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'Error!',
                                response
                                .message, // Display the error message from the server
                                'error'
                            );
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: JSON.parse(error.responseText)
                                .message,
                            customClass: {
                                container: 'my-swal-container',
                                title: 'my-swal-title',
                                content: 'my-swal-content',
                            },
                            showConfirmButton: false, // Remove the default "OK" button
                            timer: 3000, // Auto-close the alert after 3 seconds

                        });
                    }
                });
            }
        })
    });







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

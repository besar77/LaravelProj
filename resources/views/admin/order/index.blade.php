@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Order</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Orders</h4>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="order_status_form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="statusPayment">Payment Status</label>
                            <select class="form-control payment_status" name="payment_status" id="statusPayment">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="statusOrder">Order Status</label>
                            <select class="form-control order_status" name="order_status" id="statusOrder">
                                <option value="pending">Pending</option>
                                <option value="in_process">In Process
                                </option>
                                <option value="delivered">Delivered
                                </option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary submit_btn cursor-pointer">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {

            var orderId = '';

            $(document).on('click', '.order_status_btn', function() {

                let id = $(this).data('id');
                orderId = id;
                let paymentStatus = $('.payment_status option');
                let orderStatus = $('.order_status option');

                $.ajax({
                    method: 'GET',
                    url: '{{ route("admin.orders.status", ":id") }}'.replace(":id", id),

                    success: function(res) {

                        paymentStatus.each(function() {
                            if ($(this).val() == res.payment_status) {
                                $(this).attr('selected', 'selected');
                            }
                        })
                        orderStatus.each(function() {
                            if ($(this).val() == res.order_status) {
                                $(this).attr('selected', 'selected');
                            }
                        })

                        $('#order_modal').modal('show');

                    },
                    error: function(xhr, status, err) {

                    },
                    complete:function(){

                    },
                })
            });




            $('.order_status_form').on('submit', function(e) {
                e.preventDefault();
                // console.log(orderId);

                let formContent = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: '{{ route("admin.orders.status-update", ":id") }}'.replace(":id", orderId),
                    data:formContent,
                    success: function(res) {
                        $('#order-table').DataTable().draw();
                        $('#order_modal').modal('hide');
                        toastr.success(res.message);
                    },
                    error: function(xhr, status, err) {
                        toastr.error(xhr.responseJSON.message);
                    }
                })
            });
        });
    </script>
@endpush

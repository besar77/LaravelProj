@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order Preview</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Invoice</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print" id="printable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Deliver To:</strong><br>
                                        <strong>Name: </strong>
                                        {!! @$order->userAddress->firstName !!}
                                        {!! @$order->userAddress->lastName !!}
                                        <br>
                                        <strong>Phone: </strong>{!! @$order->userAddress->phone !!}<br>
                                        <strong>Address: </strong>{!! @$order->userAddress->address !!} <br>
                                        <strong>Area: </strong>{!! @$order->userAddress->deliveryArea->area_name !!}
                                    </address>
                                </div>

                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ date('F d, Y / H:i', strtotime($order->created_at)) }}
                                        <br><br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Method:</strong> {{ $order->payment_method }}<br>
                                        <strong>Payment Status:</strong>
                                        @if (strtoupper($order->payment_status) == 'COMPLETED')
                                            <span class="badge badge-success">COMPLETED</span>
                                        @elseif(strtoupper($order->payment_status) == 'PENDING')
                                            <span class="badge badge-warning">PENDING</span>
                                        @else
                                            <span class="badge badge-danger">CANCELED</span>
                                        @endif
                                        <br>
                                        <strong>Email:</strong>{{ $order->user->email }}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        @if ($order->order_status == 'delivered')
                                            <span class="badge badge-success">Delivered</span>
                                        @elseif($order->order_status == 'declined')
                                            <span class="badge badge-danger">Declined</span>
                                        @elseif($order->order_status == 'in_process')
                                            <span class="badge badge-info">In Process</span>
                                        @else
                                            <span class="badge badge-warning">{{ ucfirst($order->order_status) }}</span>
                                        @endif
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th>Size </th>
                                        <th>Optional</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    @foreach ($order->orderItems as $item)
                                        @php
                                        // dd($item);
                                            $size = json_decode($item->product_size);
                                            $option = json_decode($item->product_option);



                                            $quantity = $item->qty;
                                            $unitPrice = $item->unit_price;

                                            $sizeProd = $size[0]->price ?? 0;
                                            // dd($sizeProd);
                                            $optionPrice = 0;

                                            foreach ($option as $o) {
                                                $optionPrice += $o->price;
                                            }
                                            // dd('A jemi ne pike');
                                            $productTotal = ($unitPrice + $sizeProd + $optionPrice) * $quantity;

                                        @endphp
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>
                                                <b>{{ @$size[0]->name }}</b>({{ currencyPosition(@$size[0]->price) }})
                                            </td>
                                            <td>
                                                @foreach ($option as $o)
                                                    <b>{{ @$o->name }}</b>({{ currencyPosition(@$o->price) }})
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">{{ currencyPosition($item->unit_price) }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-right">{{ currencyPosition($productTotal) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8 d-print-none">
                                    <form action="{{ route('admin.orders.status-update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label for="statusPayment">Payment Status</label>
                                                <select class="form-control" name="payment_status" id="statusPayment">
                                                    <option @selected($order->payment_status == 'completed') value="completed">Completed
                                                    </option>
                                                    <option @selected($order->payment_status == 'pending') value="pending">Pending</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label for="statusOrder">Order Status</label>
                                                <select class="form-control" name="order_status" id="statusOrder">
                                                    <option @selected($order->order_status == 'pending') value="pending">Pending</option>
                                                    <option @selected($order->order_status == 'in_process') value="in_process">In Process
                                                    </option>
                                                    <option @selected($order->order_status == 'delivered') value="delivered">Delivered
                                                    </option>
                                                    <option @selected($order->order_status == 'declined') value="declined">Declined</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-info" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->subtotal) }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->delivery_charge) }}
                                        </div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Discount</div>
                                        <div class="invoice-detail-value">{{ currencyPosition(@$order->discount) }}
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ currencyPosition($order->grand_total) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                    </div>
                    <button class="btn btn-warning btn-icon icon-left" id="print_btn"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#print_btn').on('click', function() {
                let printContents = $('#printable').html();
                let originalContents = document.body.innerHTML;

                let printWindow = window.open('', '', 'width=600, height=600');
                printWindow.document.open();
                printWindow.document.write('<html>');
                printWindow.document.write('<link rel="stylesheet" href="{{ asset("admin/assets/modules/bootstrap/css/bootstrap.min.css") }}">');

                printWindow.document.write('<body>');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                printWindow.print();
                printWindow.close();

            });

        });
    </script>
@endpush

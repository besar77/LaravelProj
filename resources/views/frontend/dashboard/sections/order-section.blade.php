<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
    <div class="fp_dashboard_body">
        <h3>order list</h3>
        <div class="fp_dashboard_order">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr class="t_header">
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($orders as $order)
                        <tr>
                            <td>
                                <h5>#{{ $order->invoice_id }}</h5>
                            </td>
                            <td>
                                <p>{{ date('F d, Y', strtotime($order->created_at)) }}</p>
                            </td>
                            <td>
                                @if ($order->order_status === 'pending')
                                <span class="active">Pending</span>
                                @elseif ($order->order_status === 'declined')
                                <span class="cancel">Declined</span>
                                @elseif ($order->order_status === 'in_process')
                                <span class="active">In Process</span>
                                @elseif ($order->order_status === 'delivered')
                                <span class="complete">Completed</span>
                                @endif
                            </td>
                            <td>
                                <h5>{{ currencyPosition($order->grand_total) }}</h5>
                            </td>
                            <td><a class="view_invoice" onclick="viewInvoice('{{ $order->id }}')">View Details</a></td>
                        </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($orders as $order)
        <div class="fp__invoice invoice_details_{{ $order->id }}">
            <a class="go_back d-print-none"><i class="fas fa-long-arrow-alt-left"></i> go back</a>
            <div class="fp__track_order d-print-none">
                <ul style="justify-content: center;">
                    <li class="
                    {{ in_array($order->order_status, ['pending','in_process','delivered' , 'declined']) ? 'active' : '' }}
                    ">order pending</li>
                    <li class="
                    {{ in_array($order->order_status, ['in_process','delivered' ,'declined']) ? 'active' : '' }}
                    ">order in process</li>
                    @if ($order->order_status === 'delivered' || $order->order_status === 'in_process')
                    <li class="{{ $order->order_status === 'delivered' ? 'active' : '' }}">order delivered</li>
                    @endif
                    @if ($order->order_status === 'declined')
                    <li class="active declined_status">order declined</li>
                    @endif
                </ul>
            </div>
            <div class="fp__invoice_header">
                <div class="header_address">
                    <h4>invoice to</h4>
                    <p>{{ $order->userAddress->firstName }} {{ $order->userAddress->lastName }}</p>
                    <p>{{ $order->address }}</p>
                    <p>{{ @$order->userAddress->phone }}</p>
                    <p>{{ @$order->userAddress->email }}</p>
                </div>
                <div class="header_address">
                    <p><b>invoice no: </b><span>#{{ @$order->invoice_id }}</span></p>
                    <p><b>Payment Status: </b><span style="text-transform: capitalize;">{{ @$order->payment_status }}</span></p>
                    <p><b>Payment Method: </b><span style="text-transform: capitalize;">{{ @$order->payment_method }}</span></p>
                    <p><b>Transaction Id: </b><span style="text-transform: capitalize;">{{ @$order->transaction_id }}</span></p>
                    <p><b>date:</b> <span>{{ date('d-m-Y',strtotime($order->created_at)) }}</span></p>
                </div>
            </div>
            <div class="fp__invoice_body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr class="border_none">
                                <th class="sl_no">SL</th>
                                <th class="package">item description</th>
                                <th class="price">Price</th>
                                <th class="qnty">Quantity</th>
                                <th class="total">Total</th>
                            </tr>
                            @foreach ($order->orderItems as $item)
                            @php
                                $size = json_decode($item->product_size);
                                $options = json_decode($item->product_option);

                                $sizePrice = $size[0]->price ?? 0;
                                $priceProd = $item->unit_price;
                                $quantity = $item->qty;
                                $optionsPrice = 0;

                                foreach ($options as $o) {
                                    $optionsPrice += $o->price;
                                }

                                $totalPricePerProd = ($priceProd + $sizePrice + $optionsPrice) * $quantity;

                            @endphp
                            <tr>
                                <td class="sl_no">{{ ++$loop->index }}</td>
                                <td class="package">
                                    <p>{{ $item->product_name }}</p>
                                    <span class="size">{{ @$size[0]->name }} - {{ currencyPosition(@$size[0]->price) }}</span>
                                    @foreach ($options as $o)
                                        <span>{{ @$o->name }} - {{ currencyPosition(@$o->price) }}</span>
                                        <br>
                                    @endforeach
                                </td>
                                <td class="price">
                                    <b>{{ currencyPosition($item->unit_price) }}</b>
                                </td>
                                <td class="qnty">
                                    <b>{{ $item->qty }}</b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition($totalPricePerProd) }}</b>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="package" colspan="3">
                                    <b>sub total</b>
                                </td>
                                <td class="qnty">
                                    <b>12</b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition(@$order->subtotal) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package coupon" colspan="3">
                                    <b>(-) Discount coupon</b>
                                </td>
                                <td class="qnty">
                                    <b></b>
                                </td>
                                <td class="total coupon">
                                    <b>{{ currencyPosition(@$order->discount) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package coast" colspan="3">
                                    <b>(+) Shipping Cost</b>
                                </td>
                                <td class="qnty">
                                    <b></b>
                                </td>
                                <td class="total coast">
                                    <b>{{ currencyPosition(@$order->delivery_charge) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package" colspan="3">
                                    <b>Total Paid</b>
                                </td>
                                <td class="qnty">
                                    <b></b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition(@$order->grand_total) }}</b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <a class="print_btn common_btn" href="javascript:;" onclick="printInvoice('{{ $order->id }}')"><i class="far fa-print"></i>
                print
                PDF</a>

        </div>
        @endforeach


    </div>
</div>

@push('scripts')
    <script>
            function viewInvoice(id){
                // $('.invoice_details_'+id).css('display','block');

            $(".fp_dashboard_order").fadeOut();
            $(".invoice_details_"+id).fadeIn();
            }

            function printInvoice(id)
            {
                let printContents = $('.invoice_details_'+id).html();

                let printWindow = window.open('', '', 'width=600, height=600');
                printWindow.document.open();
                printWindow.document.write('<html>');
                printWindow.document.write('<link rel="stylesheet" href="{{ asset("frontend/css/bootstrap.min.css") }}">');
                printWindow.document.write('<link rel="stylesheet" href="{{ asset("frontend/css/style.css") }}">');

                printWindow.document.write('<body>');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // printWindow.print();
                // printWindow.close();
            }

    </script>
@endpush

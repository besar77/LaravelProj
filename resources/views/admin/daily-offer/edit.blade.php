@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update DailyOffer - {{ $dailyOffer->name }}</h1>
        </div>

        <div class="card card-primary">

            <div class="card-body">
                <form action="{{ route('admin.dailyOffers.update', $dailyOffer->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Product</label>
                        <select id="product_search" class="form-control" name="prod_id">
                            <option value="{{ $dailyOffer->product->id }}">{{ $dailyOffer->product->name }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option @selected($dailyOffer->status === 1) value="1">Active</option>
                            <option @selected($dailyOffer->status === 0) value="0">InActive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>

                </form>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#product_search').select2({
                ajax: {
                    url: "{{ route('admin.dailyOffer.searchProduct') }}",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(product) {
                                return {
                                    text: product.name,
                                    id: product.id,
                                    image_url: product.thumb_image
                                }
                            })
                        }
                    }
                },
                minimumInputLength: 3,
                templateResult: formatProduct,
                escapeMarkup: function(m) {
                    return m;
                }
            });

            function formatProduct(prod) {
                var prod = $('<span><img src="' + prod.image_url +
                    '" style="width:50px; margin-right:20px;" class="img-thumbnail" >' +
                    prod.text +
                    '</span>');
                return prod;
            }

        });
    </script>
@endpush

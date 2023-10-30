@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product - {{ $deliveryArea->name }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update product - {{ $deliveryArea->name }}</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.delivery-area.update', $deliveryArea->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf


                    <div class="form-group">
                        <label>Area name</label>
                        <input type="text" class="form-control" name="area_name" value="{{ $deliveryArea->area_name }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min delivery time</label>
                                <input type="text" class="form-control" name="min_delivery_time"
                                    value="{{ $deliveryArea->min_delivery_time }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max Delivery Time</label>
                                <input type="text" class="form-control" name="max_delivery_time"
                                    value="{{ $deliveryArea->max_delivery_time }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delivery fee</label>
                                <input type="number" class="form-control" name="delivery_fee"
                                    value="{{ $deliveryArea->delivery_fee }}" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select id="" class="form-control" name="status">
                                    <option @selected($deliveryArea->status == '1') value="1">Active</option>
                                    <option @selected($deliveryArea->status == '0') value="0">InActive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>

                </form>
            </div>
        </div>

    </section>
@endsection

@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header">
            {{-- <h1>Product Gallery - {{ $prod->name }}</h1> --}}
            <h1>Product Sizes/Options</h1>
        </div>

        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-5">Go back</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        {{-- <h4>All Images of product: {{ $prod->name }}</h4> --}}
                        <h4>Create Product Sizes</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.product-size.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="card card-primary">

                    @if (count($sizes) === 0)
                        <h3 class="p-5 text-center">Sorry there are no sizes for this product.</h3>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $i)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>
                                            {{ $i->name }}
                                        </td>
                                        <td>
                                            {{ currencyPosition($i->price) }}
                                        </td>
                                        <td><a href="{{ route('admin.product-size.destroy', $i->id) }}"
                                                class="btn btn-danger delete-item">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif


                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        {{-- <h4>All Images of product: {{ $prod->name }}</h4> --}}
                        <h4>Create Product Options</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.product-option.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="card card-primary">

                    @if (count($options) === 0)
                        <h3 class="p-5 text-center">Sorry there are no options for this product.</h3>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $i)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>
                                            {{ $i->name }}
                                        </td>
                                        <td>
                                            {{ currencyPosition($i->price) }}
                                        </td>
                                        <td><a href="{{ route('admin.product-option.destroy', $i->id) }}"
                                                class="btn btn-danger delete-item">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif


                </div>
            </div>

        </div>



    </section>
@endsection

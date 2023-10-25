@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Product Gallery - {{ $prod->name }}</h1>
        </div>

        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-5">Go back</a>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Images of product: {{ $prod->name }}</h4>
            </div>
            <div class="card-body">
                <div class="col-md-8">
                    <form action="{{ route('admin.product-gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" value="{{ $prodId }}" name="product_id">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card-primary">

            @if (count($images) === 0)
                <h3 class="p-5 text-center">Sorry there are no photos to show.</h3>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $i)
                            <tr>
                                <td>
                                    <img src="{{ asset($i->image) }}" alt="{{ $i->image }}" width="200px"
                                        class="p-3">
                                </td>
                                <td><a href="{{ route('admin.product-gallery.destroy', $i->id) }}"
                                        class="btn btn-danger delete-item">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


        </div>


    </section>
@endsection

@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product - {{ $prod->name }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update product - {{ $prod->name }}</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.update', $prod->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview"
                                style="background-image: url('{{ asset($prod->thumb_image) }}'); background-size: cover; background-position: center center;">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $prod->name }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select id="" class="form-control select2" name="category">
                            <option value="">Select</option>
                            @foreach ($categories as $c)
                                <option @if ($prod->category_id == $c->id) selected @endif value="{{ $c->id }}">
                                    {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" name="price" value="{{ $prod->price }}">
                    </div>
                    <div class="form-group">
                        <label>Offer Price</label>
                        <input type="text" class="form-control" name="offer_price" value="{{ $prod->offer_price }}">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="{{ $prod->quantity }}">
                    </div>

                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="short_description" class="form-control">{!! $prod->short_description !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea name="long_description" class="form-control summernote">{!! $prod->long_description !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Sku</label>
                        <input type="text" class="form-control" name="sku" value="{{ $prod->sku }}">
                    </div>

                    <div class="form-group">
                        <label>Seo Title</label>
                        <input type="text" class="form-control" name="seo_title" value="{{ $prod->seo_title }}">
                    </div>

                    <div class="form-group">
                        <label>Seo Description</label>
                        <textarea name="seo_description" class="form-control">{!! $prod->seo_description !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Show At Home</label>
                        <select id="" class="form-control" name="show_at_home">
                            <option @if ($prod->show_at_home === 1) selected @endif value="1">Yes</option>
                            <option @if ($prod->show_at_home === 0) selected @endif value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option @if ($prod->status === 1) selected @endif value="1" value="1">Active
                            </option>
                            <option @if ($prod->status === 0) selected @endif value="0" value="0">InActive
                            </option>
                        </select>
                    </div>


                    <button class="btn btn-primary" type="submit">Update</button>

                </form>
            </div>
        </div>

    </section>
@endsection

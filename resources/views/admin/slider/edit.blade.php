@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update Slider</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Card Header</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-7">
                            <label>Image</label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Offer</label>
                        <input type="text" class="form-control" name="offer" value="{{ $slider->offer }}">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $slider->title }}">
                    </div>
                    <div class="form-group">
                        <label>Sub Title</label>
                        <input type="text" class="form-control" name="sub_title" value="{{ $slider->sub_title }}">
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea id="" cols="30" rows="10" class="form-control" name="short_description">{{ $slider->short_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Button Link</label>
                        <input type="text" class="form-control" name="button_link" value="{{ $slider->button_link }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option value="" @if ($slider->status === '') selected @endif></option>
                            <option value="1" @if ($slider->status === 1) selected @endif>Active</option>
                            <option value="0" @if ($slider->status === 0) selected @endif>InActive</option>
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

            $('.image-preview').css({
                'background-image': 'url({{ asset($slider->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

        });
    </script>
@endpush

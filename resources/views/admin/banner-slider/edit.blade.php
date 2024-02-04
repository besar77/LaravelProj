@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update Banner</h1>
        </div>

        <div class="card card-primary">

            <div class="card-body">
                <form action="{{ route('admin.bannerSlider.update', $bannerSlider->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-7">
                            <label>Image</label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload" />
                                <input type="hidden" name="old_image" value="{{ $bannerSlider->banner }}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $bannerSlider->title }}">
                    </div>
                    <div class="form-group">
                        <label>SubTitle</label>
                        <input type="text" class="form-control" name="subtitle" value="{{ $bannerSlider->subTitle }}">
                    </div>
                    <div class="form-group">
                        <label>Url</label>
                        <input type="text" class="form-control" name="url" value="{{ $bannerSlider->url }}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option @selected($bannerSlider->status === 1) value="1">Active</option>
                            <option @selected($bannerSlider->status === 0) value="0">InActive</option>
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
                'background-image': 'url({{ asset($bannerSlider->banner) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

        });
    </script>
@endpush

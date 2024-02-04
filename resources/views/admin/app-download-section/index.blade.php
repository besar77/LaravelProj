@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>App Download Section</h1>
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <form action="{{ route('admin.app-download.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12 col-md-7">
                                    <label>Image</label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Choose File</label>
                                        <input type="file" name="image" id="image-upload" />
                                        <input type="hidden" name="old_image" value="{{ $res->image }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12 col-md-7">
                                    <label>Background</label>
                                    <div id="image-preview-2" class="image-preview">
                                        <label for="image-upload" id="image-label-2">Choose File</label>
                                        <input type="file" name="background" id="image-upload-2" />
                                        <input type="hidden" name="old_background" value="{{ $res->background }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value={{ $res->title }}>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="short_description" class="form-control">{{ $res->short_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Play Store Link <code>(Leave empty to hide)</code></label>
                        <input type="text" class="form-control" name="play_store_link" value={{ $res->play_store_link }}>
                    </div>

                    <div class="form-group">
                        <label>App Store Link <code>(Leave empty to hide)</code></label>
                        <input type="text" class="form-control" name="apple_store_link" value={{ $res->app_store_link }}>
                    </div>

                    <button class="btn btn-primary" type="submit">Create</button>

                </form>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        $.uploadPreview({
            input_field: "#image-upload-2", // Default: .image-upload
            preview_box: "#image-preview-2", // Default: .image-preview
            label_field: "#image-label-2", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.image-preview').css({
                'background-image': 'url({{ asset($res->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

        });

        $(document).ready(function() {

            $('.image-preview').css({
                'background-image-2': 'url({{ asset($res->background) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });

        });
    </script>
@endpush

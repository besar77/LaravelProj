@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Chef</h1>
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <form action="{{ route('admin.chef.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>

                    <br>
                    <h4>Social Links</h4>
                    <div class="form-group">
                        <label>Facebook <code>(Leave empty if not show)</code></label>
                        <input type="text" class="form-control" name="fb" value="{{ old('fb') }}">
                    </div>
                    <div class="form-group">
                        <label>Linkedin <code>(Leave empty if not show)</code></label>
                        <input type="text" class="form-control" name="in" value="{{ old('in') }}">
                    </div>
                    <div class="form-group">
                        <label>Twitter <code>(Leave empty if not show)</code></label>
                        <input type="text" class="form-control" name="x" value="{{ old('x') }}">
                    </div>
                    <div class="form-group">
                        <label>Web <code>(Leave empty if not show)</code></label>
                        <input type="text" class="form-control" name="web" value="{{ old('web') }}">
                    </div>

                    <div class="form-group">
                        <label>Show At Home Page</label>
                        <select id="" class="form-control" name="show_at_home">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Add</button>

                </form>
            </div>
        </div>

    </section>
@endsection

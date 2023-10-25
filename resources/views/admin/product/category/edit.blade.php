@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update Category</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Category</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                    </div>
                    <div class="form-group">
                        <label>Show At Home</label>
                        <select id="" class="form-control" name="show_at_home">
                            <option value="1" @if ($category->show_at_home === 1) selected @endif>Yes</option>
                            <option value="0" @if ($category->show_at_home === 0) selected @endif>No</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option value="1" @if ($category->status === 1) selected @endif>Active</option>
                            <option value="0" @if ($category->status === 0) selected @endif>InActive</option>
                        </select>

                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>

                </form>
            </div>
        </div>

    </section>
@endsection

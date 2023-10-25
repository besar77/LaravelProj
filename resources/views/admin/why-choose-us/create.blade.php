@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Why Choose Us Section</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Item</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.why-choose-us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Icon</label>
                        <br>
                        <button class="btn btn-primary" role="iconpicker" name="icon"></button>
                    </div>
                    <div class="form-group">
                        <label>Title</label>

                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea id="" cols="30" rows="10" class="form-control" name="short_description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="" class="form-control" name="status">
                            <option value=""></option>
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Create</button>

                </form>
            </div>
        </div>

    </section>
@endsection

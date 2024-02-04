@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chefs</h1>
        </div>


        <div class="card">
            <div class="card-body">

                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-white p-3" role="button" data-toggle="collapse"
                            data-target="#panel-body-1" aria-expanded="false">
                            <h4>Chefs Section Titles...</h4>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                            <form action="{{ route('admin.chef-title.update') }}" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label for="">Top Title</label>
                                    <input type="text" class="form-control" name="chef_top_title"
                                        value="{{ @$titles->firstWhere('key', 'chef_top_title')->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Main Title</label>
                                    <input type="text" class="form-control" name="chef_main_title"
                                        value="{{ @$titles->firstWhere('key', 'chef_main_title')->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="chef_sub_title"
                                        value="{{ @$titles->firstWhere('key', 'chef_sub_title')->value }}">
                                </div>




                                <button class="btn btn-primary" type="submit">Save</button>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <section class="section">

        <div class="section-header">
            <h1>Chefs</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Chefs</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.chef.create') }}" class="btn btn-primary">
                        Add a new chef
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

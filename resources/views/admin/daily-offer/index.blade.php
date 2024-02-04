@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daily Offer</h1>
        </div>


        <div class="card">
            <div class="card-body">

                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-white p-3" role="button" data-toggle="collapse"
                            data-target="#panel-body-1" aria-expanded="false">
                            <h4>Daily Offer Section Titles...</h4>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                            <form action="{{ route('admin.dailyOffer-title.update') }}" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label for="">Top Title</label>
                                    <input type="text" class="form-control" name="daily_offer_top_title"
                                        value="{{ @$titles->firstWhere('key', 'daily_offer_top_title')->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Main Title</label>
                                    <input type="text" class="form-control" name="daily_offer_main_title"
                                        value="{{ @$titles->firstWhere('key', 'daily_offer_main_title')->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="daily_offer_sub_title"
                                        value="{{ @$titles->firstWhere('key', 'daily_offer_sub_title')->value }}">
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

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Daily Offers</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.dailyOffers.create') }}" class="btn btn-primary">
                        Create New Delivery Area
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

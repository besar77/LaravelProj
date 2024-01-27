@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Daily Offers</h1>
        </div>

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

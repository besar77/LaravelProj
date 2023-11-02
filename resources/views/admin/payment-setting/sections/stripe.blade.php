<div class="tab-pane fade" id="stripe-setting" role="tabpanel" aria-labelledby="stripe-tab4">
    <div class="card-body border">

        <form action="{{ route('admin.stripe-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="">Stripe Status</label>
                <select id="" class="select2 form-control" name="stripe_status">
                    <option @selected(@$paymentGateway['stripe_status'] === '1') value="1">Active</option>
                    <option @selected(@$paymentGateway['stripe_status'] === '0') value="0">Inactive</option>
                </select>
            </div>

            {{-- <div class="form-group">
                <label for="">Stripe Account Mode</label>
                <select id="" class="select2 form-control" name="paypal_account_mode">
                    <option @selected(@$paymentGateway['paypal_account_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                    <option @selected(@$paymentGateway['paypal_account_mode'] === 'live') value="live">Live</option>
                </select>
            </div> --}}

            <div class="form-group">
                <label for="">Stripe Country Name</label>
                <select id="" class="select2 form-control" name="stripe_country">
                    <option value="">Select</option>
                    @foreach (config('country_list') as $key => $c)
                        <option @selected(@$paymentGateway['stripe_country'] === $key) value="{{ $key }}">{{ $c }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="">Stripe Currency</label>
                <select id="" class="select2 form-control" name="stripe_currency">
                    <option value="">Select</option>
                    @foreach (config('currencys.currency_list') as $currency)
                        <option @selected(@$paymentGateway['stripe_currency'] === $currency) value="{{ $currency }}">
                            {{ $currency }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }} )</label>
                <input type="text" class="form-control" value="{{ @$paymentGateway['stripe_rate'] }}"
                    name="stripe_rate">
            </div>

            @if (auth()->user()->role === 'admin')
                <div class="form-group">
                    <label for="">Stripe Key</label>
                    <input type="text" class="form-control" value="{{ @$paymentGateway['stripe_api_key'] }}"
                        name="stripe_api_key">
                </div>


                <div class="form-group">
                    <label for="">Stripe Secrey Key</label>
                    <input type="text" class="form-control" value="{{ @$paymentGateway['stripe_secret_key'] }}"
                        name="stripe_secret_key">
                </div>
            @endif

            <div class="form-group">
                <label for="image-upload">Stripe Logo</label>
                <div id="image-preview" class="image-preview"
                    style="background-image: url('{{ asset(@$paymentGateway['stripe_logo']) }}');
                background-size: cover;
                background-position: center;">
                    <label for="image-upload" id="image-label">Choose File</label>
                    <input type="file" name="stripe_logo" id="image-upload" />
                </div>
            </div>

            @if (auth()->user()->role === 'admin')
                <button type="submit" class="btn btn-primary">Save</button>
            @endif
        </form>

    </div>
</div>

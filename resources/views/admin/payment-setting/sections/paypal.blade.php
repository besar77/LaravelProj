<div class="tab-pane fade active show" id="paypal-setting" role="tabpanel" aria-labelledby="paypal-tab4">
    <div class="card-body border">

        <form action="{{ route('admin.paypal-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="">Paypal Status</label>
                <select id="" class="select2 form-control" name="paypal_status">
                    <option @selected(@$paymentGateway['paypal_status'] === '1') value="1">Active</option>
                    <option @selected(@$paymentGateway['paypal_status'] === '0') value="0">Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Paypal Account Mode</label>
                <select id="" class="select2 form-control" name="paypal_account_mode">
                    <option @selected(@$paymentGateway['paypal_account_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                    <option @selected(@$paymentGateway['paypal_account_mode'] === 'live') value="live">Live</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Paypal Country Name</label>
                <select id="" class="select2 form-control" name="paypal_country">
                    <option value="">Select</option>
                    @foreach (config('country_list') as $key => $c)
                        <option @selected(@$paymentGateway['paypal_country'] === $key) value="{{ $key }}">{{ $c }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="">Paypal Currency</label>
                <select id="" class="select2 form-control" name="paypal_currency">
                    <option value="">Select</option>
                    @foreach (config('currencys.currency_list') as $currency)
                        <option @selected(@$paymentGateway['paypal_currency'] === $currency) value="{{ $currency }}">
                            {{ $currency }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }} )</label>
                <input type="text" class="form-control" value="{{ @$paymentGateway['paypal_rate'] }}"
                    name="paypal_rate">
            </div>

            @if (auth()->user()->role === 'admin')
                <div class="form-group">
                    <label for="">Paypal Client Id</label>
                    <input type="text" class="form-control" value="{{ @$paymentGateway['paypal_api_key'] }}"
                        name="paypal_api_key">
                </div>


                <div class="form-group">
                    <label for="">Paypal Secrey Key</label>
                    <input type="text" class="form-control" value="{{ @$paymentGateway['paypal_secret_key'] }}"
                        name="paypal_secret_key">
                </div>

                <div class="form-group">
                    <label for="">Paypal App Id</label>
                    <input type="text" class="form-control" value="{{ @$paymentGateway['paypal_app_id'] }}"
                        name="paypal_app_id">
                </div>
            @endif

            <div class="form-group">
                <label for="image-upload">Paypal Logo</label>
                <div id="image-preview" class="image-preview"
                    style="background-image: url('{{ asset(@$paymentGateway['paypal_logo']) }}');
                background-size: cover;
                background-position: center;">
                    <label for="image-upload" id="image-label">Choose File</label>
                    <input type="file" name="paypal_logo" id="image-upload" />
                </div>
            </div>

            @if (auth()->user()->role === 'admin')
                <button type="submit" class="btn btn-primary">Save</button>
            @endif
        </form>

    </div>
</div>

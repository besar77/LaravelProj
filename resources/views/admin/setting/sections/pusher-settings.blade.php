<div class="tab-pane fade" id="pusher-setting" role="tabpanel" aria-labelledby="profile-tab4">
    <div class="card-body border">
        <form action="{{ route('admin.general-setting.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="">Site Name</label>
                <input type="text" class="form-control" name="site_name"
                    value="{{ config('settings.site_name') }}">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

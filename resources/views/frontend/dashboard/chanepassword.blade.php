<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    <div class="fp_dashboard_body fp__change_password">
        <div class="fp__review_input">
            <h3>change password</h3>
            <div class="comment_input pt-0">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="form-group">
                            <label>Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="current_password"
                                    id="password_current">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('password_current')">
                                        <i class="far fa-eye" id="password_currentIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="passwordField">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('passwordField')">
                                        <i id="passwordFieldIcon" class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>



                        <div class="col-xl-12">

                            <div class="fp__comment_imput_single">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="passwordConfirmationField">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePasswordVisibility('passwordConfirmationField')">
                                            <i id="passwordConfirmationFieldIcon" class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="common_btn mt_20">submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('customJs/togglePasswordVisibility.js') }}"></script>

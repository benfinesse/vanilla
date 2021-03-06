<div class="nk-block">
    <div class="row g-gs">
        <div class="col-md-6">
            <div class="card card-bordered card-full">
                <div class="nk-wg1">
                    <div class="nk-wg1-block">
                        <div class="nk-wg1-img">
                            <img src="{{ url('svg/report_history.svg') }}" alt="">
                        </div>
                        <div class="nk-wg1-text">
                            <h5 class="title">Record History</h5>
                            <p>Check out all Record history. You can also download to excel for convenience.</p>
                        </div>
                    </div>
                    <div class="nk-wg1-action">
                        <a href="{{ route('record.index') }}" class="link"><span>All Records</span> <em class="icon ni ni-chevron-right"></em></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-bordered card-full">
                <div class="nk-wg1">
                    <div class="nk-wg1-block">
                        <div class="nk-wg1-img">
                            <img src="{{ url('svg/profile.svg') }}" alt="">

                        </div>
                        <div class="nk-wg1-text">
                            <h5 class="title">Personal Info</h5>
                            <p>See your profile data and manage your Account.</p>
                        </div>
                    </div>
                    <div class="nk-wg1-action">
                        <a href="{{ route('account.show', $person->uuid) }}" class="link"><span>Manage Your Account</span> <em class="icon ni ni-chevron-right"></em></a>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .row -->
</div>
<div class="mb-5"></div>
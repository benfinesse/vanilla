@if($pending->count()>0)
    <div class="nk-block">
        <h5 class="nk-block-title fw-normal mb-3">You have {{ $pending->count() }} Pending Records that needs your attention</h5>
        <div class="row g-gs">
            @foreach($pending as $record)
                @if(!empty($record->CurrentOfficeSlip))
                    <div class="col-md-4">
                        <div class="card card-bordered card-full">
                            <div class="nk-wg1">
                                <div class="nk-wg1-block">
                                    <div class="nk-wg1-text">
                                        <h5 class="title">{{ $record->CurrentOfficeSlip->office->name }}'s Office</h5>
                                        <p>{{ $record->title }}.</p>
                                        <small>Submitted by <b>{{ $record->CurrentOfficeSlip->user->names }}</b> on {{ date('F d, Y', strtotime($record->CurrentOfficeSlip->created_at)) }} </small>
                                    </div>
                                </div>
                                <div class="nk-wg1-action">
                                    <a href="{{ route('record.audit', $record->uuid) }}" class="link"><span>Review Record</span> <em class="icon ni ni-chevron-right"></em></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div><!-- .row -->
    </div>
    <div class="mb-5"></div>
@endif

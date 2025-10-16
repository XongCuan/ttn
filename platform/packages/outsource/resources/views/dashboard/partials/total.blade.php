<div class="row row-deck row-cards">

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3 text-primary">
                    <div class="fs-4 text-muted fw-bold">@lang('Tổng dự án')</div>
                    <div class="fs-1 fw-bold text">{{ $count_p_all }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3 text-green">
                    <div class="fs-4 text-muted fw-bold">@lang('Dự án hoàn thành')</div>
                    <div class="fs-1 fw-bold text">{{ $count_p_done }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3 text-green">
                    <div class="fs-4 text-muted fw-bold">@lang('Tỉ lệ hoàn thành')</div>
                    <div class="fs-1 fw-bold text">{{ $percent_p_done }}%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column mb-3 text-danger">
                    <div class="fs-4 text-muted fw-bold">@lang('Trễ deadline')</div>
                    <div class="fs-1 fw-bold text">{{ $count_p_late }}</div>
                </div>
                <div class="ms-auto text-end">
                    <div class="badge bg-red-lt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('Tỉ lệ phần trăm')">
                        <span class="me-1">@lang('Tỉ lệ'):</span>
                        <span class="d-inline-flex align-items-center lh-1">
                            {{ $percent_p_late }}% 
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
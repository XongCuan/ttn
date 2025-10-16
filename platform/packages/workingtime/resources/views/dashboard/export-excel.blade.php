<table class="table table-vcenter table-striped">
    <thead>
        <tr>
            <th>@lang('STT')</th>
            <th>@lang('Phòng ban')</th>
            <th>@lang('Tên NV')</th>
            <th>@lang('Số ngày công')</th>
            <th>@lang('Off có phép')</th>
            <th>@lang('Off không phép')</th>
            <th>@lang('OT(giờ)')</th>
            <th>@lang('Thiếu giờ (lần)')</th>
            <th>@lang('Thiếu giờ (ngày)')</th>
            <th>@lang('Đi trễ (lần)')</th>
            <th>@lang('Đi trễ (ngày)')</th>
            <th>@lang('Tổng vi phạm (lần)')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($statistic as $item)
            @php
                $offAnual = $item->countAnnualLeave();
                $off = $item->countUnpaidLeave();
                $dateNotEnough = $item->dateNotEnoughHours();
                $late = $item->dateLate();
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{!! $item->admin->getDepartmentBadge() !!}</td>
                <td>{{ $item->admin->fullname }}</td>
                <td>{{ $item->countRequestAddToWorkingTIme() + $item->countPassDate() }}</td>
                <td>{{ $offAnual }}</td>
                <td>{{ $off }}</td>
                <td></td>
                <td>{{ count($dateNotEnough) }}</td>
                <td>{{ implode(', ', $dateNotEnough) }}</td>
                <td>{{ count($late) }}</td>
                <td>{{ implode(', ', $late) }}</td>
                <td>{{ count($dateNotEnough) + count($late) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

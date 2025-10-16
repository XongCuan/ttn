@lang('Start: :date', ['date' => format_date($data->start_date) ])
<br>
@lang('End: :date', ['date' => format_date($data->end_date) ])
<br>
@if ($data->demo_date)
@lang('Demo: :date', ['date' => format_date($data->demo_date) ])
    <span @class(['badge', $data->demo_ontime ? 'bg-green' : 'bg-red'])></span>
@endif

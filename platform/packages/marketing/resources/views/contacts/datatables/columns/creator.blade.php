<div class="d-flex gap-1 flex-wrap">
    @if($data->creator->fullname())
        {{ $data->creator->fullname() }}
        {!! $data->creator->getTeamBadge() !!}
        {!! $data->creator->getRoleBadge() !!}
        {!! $data->creator->getDepartmentBadge() !!}
    @endif
</div>
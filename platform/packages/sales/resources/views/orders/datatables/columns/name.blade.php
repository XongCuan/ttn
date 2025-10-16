<div class="d-flex flex-column gap-2">
    <div class="">
        <span>{{ $data->name }}</span>
        @if($data->isPriority())
            <span @class(['badge', $data->priority->badge()])>{{ $data->priority->description() }}</span>
        @endif
    </div>
</div>
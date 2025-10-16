<div class="d-flex flex-column gap-2">
    <div class="">
        <span>{{ $data->name }}</span>
        <span @class(['badge', $data->scale->badge()])>{{ $data->scale->description() }}</span>
    </div>
</div>
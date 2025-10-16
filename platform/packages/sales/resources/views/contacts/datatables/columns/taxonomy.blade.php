<div class="d-flex gap-1 flex-wrap">
    @if($data->source->name)
        <span class="badge bg-blue text-blue-fg">{{ $data->source->name }}</span>
    @endif
    @if($data->type->name)
        <span class="badge bg-blue text-blue-fg">{{ $data->type->name }}</span>
    @endif
    @if($data->area)
    <span class="badge bg-blue text-blue-fg">{{ $data->area->description() }}</span>
    @endif
    @if($data->rangePrice->name)
        <span class="badge bg-blue text-blue-fg">{{ $data->rangePrice->name }}</span>
    @endif
</div>
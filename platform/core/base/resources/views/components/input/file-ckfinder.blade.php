<div class="input-group">
    <input type="text" {{ $attributes->class(['form-control'])->merge($isRequired()) }} name="{{ $name }}" value="{{ $value }}">
    <div class="input-group-append">
        <button class="btn-outline-secondary add-file-ckfinder" type="button" data-input="input[name='{{ $name }}']">
            @lang('choose')
        </button>
    </div>
</div>
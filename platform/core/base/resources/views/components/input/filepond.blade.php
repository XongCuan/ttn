<div class="wrap-filepond" data-target-file="input[name='{{$targetFile}}']">
    @if($value)
        <input type="hidden" name="{{ $targetFile }}" value="{{ $marcoValue($value) }}"/>
    @endif
    <input type="file" name="{{ $name }}" {{ $attributes->class(['form-control filepond'])->merge($isRequired()) }} {{$multiple()}} />
</div>
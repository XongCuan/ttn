<label class="form-check" style="--cat-depth: {{ $depth }}px">
    <input type="radio" {{ $attributes->class(['form-check-input']) }} {{ $isChecked() }} value="{{ $value }}">
    <span class="form-check-label">{{ $label }}</span>
</label>
<input type="email" 
{{ $attributes
    ->class(['form-control'])
    ->merge([
        'placeholder' => __('Email'),
        'data-parsley-type-message' => __('Email không hợp lệ'),
    ])->merge($isRequired())
}}>
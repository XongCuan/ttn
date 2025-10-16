<?php

namespace TCore\Support\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringToNumberLessthan implements ValidationRule
{
    public function __construct(
        public $compare
    )
    {
        
    }
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (string_to_integer($value) > string_to_integer($this->compare))
        {
            $fail('Trường :attribute phải nhỏ hơn trường khác.');
        }
    }
}

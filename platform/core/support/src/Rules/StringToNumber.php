<?php

namespace TCore\Support\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringToNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/^\d{1,3}(,\d{3})*$/', $value) == false)
        {
            $fail('Trường :attribute phải là số.');
        }
    }
}

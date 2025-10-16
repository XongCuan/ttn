<?php

namespace TCore\Sales\Http\Requests;

use TCore\Support\Http\Requests\Request;
use TCore\Support\Rules\StringToNumber;
use TCore\Support\Rules\StringToNumberLessthan;

class RangePriceRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'min_price' => ['required', new StringToNumber, new StringToNumberLessthan($this->input('max_price', 0))],
            'max_price' => ['required', new StringToNumber]
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\RangePrice,id'],
            'name' => ['required', 'string'],
            'min_price' => ['required', new StringToNumber, new StringToNumberLessthan($this->input('max_price', 0))],
            'max_price' => ['required', new StringToNumber]
        ];
    }
}
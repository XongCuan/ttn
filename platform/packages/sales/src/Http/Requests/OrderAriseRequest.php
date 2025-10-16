<?php

namespace TCore\Sales\Http\Requests;

use TCore\Support\Http\Requests\Request;
use TCore\Support\Rules\StringToNumber;

class OrderAriseRequest extends Request
{
    protected function methodPost()
    {
        return [
            'order_id' => ['required', 'exists:App\Models\Order,id'],
            'name' => ['required', 'string'],
            'amount' => ['required', new StringToNumber],
            'desc' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\OrderArise,id'],
            'name' => ['required', 'string'],
            'amount' => ['required', new StringToNumber],
            'desc' => ['nullable'],
        ];
    }
}
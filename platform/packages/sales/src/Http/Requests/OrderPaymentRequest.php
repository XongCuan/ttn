<?php

namespace TCore\Sales\Http\Requests;

use TCore\Support\Http\Requests\Request;
use TCore\Support\Rules\StringToNumber;

class OrderPaymentRequest extends Request
{
    protected function methodPost()
    {
        if($this->routeIs('sales.order_payment.store_fake'))
        {
            return [
                'name' => ['required', 'string'],
                'amount' => ['required', new StringToNumber],
                'desc' => ['required']
            ];
        }

        return [
            'order_id' => ['required', 'exists:App\Models\Order,id'],
            'name' => ['required', 'string'],
            'amount' => ['required', new StringToNumber],
            'desc' => ['required']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\OrderPayment,id'],
            'name' => ['required', 'string'],
            'amount' => ['required', new StringToNumber],
            'desc' => ['nullable'],
        ];
    }
}
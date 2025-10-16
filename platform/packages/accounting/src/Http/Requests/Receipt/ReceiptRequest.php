<?php

namespace TCore\Accounting\Http\Requests\Receipt;

use TCore\Support\Http\Requests\Request;
use TCore\Support\Rules\StringToNumber;

class ReceiptRequest extends Request
{
    protected function methodPost()
    {
        return [
            'type_id' => ['required', 'exists:App\Models\ReceiptType,id'],
            'amount' => ['required', new StringToNumber],
            'receipt_date' => ['required', 'date_format:Y-m-d'],
            'desc' => ['nullable'],
            'attachments' => ['required', 'array'],
            'attachments.*' => ['nullable', 'json'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\ReceiptType'],
            'name' => ['required', 'string'],
            'desc' => ['nullable']
        ];
    }
}
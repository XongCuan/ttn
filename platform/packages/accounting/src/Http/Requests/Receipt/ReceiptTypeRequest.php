<?php

namespace TCore\Accounting\Http\Requests\Receipt;

use TCore\Support\Http\Requests\Request;

class ReceiptTypeRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'desc' => ['nullable']
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
<?php

namespace TCore\Sales\Http\Requests;

use App\Enums\Customer\CustomerReturnStatus;
use Illuminate\Validation\Rules\Enum;
use TCore\Support\Http\Requests\Request;

class CustomerReturnRequest extends Request
{
    protected function methodPost()
    {
        return [
            'customer_id' => ['required', 'exists:App\Models\Customer,id'],
            'note' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:TCore\Sales\Models\CustomerReturn,id'],
            'status' => ['required', new Enum(CustomerReturnStatus::class)],
            'note' => ['nullable']
        ];
    }
}
<?php

namespace TCore\WorkingTime\Http\Requests;

use TCore\Support\Http\Requests\Request;

class TypeOvertimeRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'value' => ['required']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\TypeOvertime,id'],
            'name' => ['required', 'string'],
            'value' => ['required']
        ];
    }
}
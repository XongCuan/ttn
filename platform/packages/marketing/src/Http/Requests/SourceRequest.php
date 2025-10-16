<?php

namespace TCore\Marketing\Http\Requests;

use TCore\Support\Http\Requests\Request;

class SourceRequest extends Request
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
            'id' => ['required', 'exists:App\Models\Source,id'],
            'name' => ['required', 'string'],
            'desc' => ['nullable']
        ];
    }
}
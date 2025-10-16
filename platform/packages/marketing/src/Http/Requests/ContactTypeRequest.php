<?php

namespace TCore\Marketing\Http\Requests;

use TCore\Support\Http\Requests\Request;

class ContactTypeRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'note' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\ContactType,id'],
            'name' => ['required', 'string'],
            'note' => ['nullable']
        ];
    }
}
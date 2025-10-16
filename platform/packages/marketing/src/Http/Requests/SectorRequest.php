<?php

namespace TCore\Marketing\Http\Requests;

use TCore\Support\Http\Requests\Request;

class SectorRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Sector,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable']
        ];
    }
}
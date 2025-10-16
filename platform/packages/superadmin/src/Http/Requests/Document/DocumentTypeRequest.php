<?php

namespace TCore\Superadmin\Http\Requests\Document;

use TCore\Support\Http\Requests\Request;

class DocumentTypeRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:App\Models\DocumentType,id'],
            'desc' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\DocumentType'],
            'parent_id' => ['nullable', 'different:id', 'exists:App\Models\DocumentType,id'],
            'name' => ['required', 'string'],
            'desc' => ['nullable']
        ];
    }
}
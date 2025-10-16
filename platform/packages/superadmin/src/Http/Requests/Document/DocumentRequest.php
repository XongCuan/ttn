<?php

namespace TCore\Superadmin\Http\Requests\Document;

use TCore\Support\Http\Requests\Request;

class DocumentRequest extends Request
{
    protected function methodPost()
    {
        return [
            'type_id' => ['required', 'exists:App\Models\DocumentType,id'],
            'document_date' => ['required', 'date_format:Y-m-d'],
            'desc' => ['nullable'],
            'attachments' => ['required', 'array'],
            'attachments.*' => ['nullable', 'json'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\DocumentType'],
            'name' => ['required', 'string'],
            'desc' => ['nullable']
        ];
    }
}
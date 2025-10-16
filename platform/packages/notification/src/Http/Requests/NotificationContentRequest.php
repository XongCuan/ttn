<?php

namespace TCore\Notification\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use TCore\Base\Enums\Department;
use TCore\Support\Http\Requests\Request;

class NotificationContentRequest extends Request
{
    protected function methodPost()
    {
        return [
            'title' => ['required', 'string'],
            'is_all' => ['nullable', 'boolean'],
            'target_deparments' => ['nullable', 'array'],
            'target_deparments.*' => ['nullable', new Enum(Department::class)],
            'content' => ['required']
        ];
    }
}
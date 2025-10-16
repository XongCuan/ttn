<?php

namespace TCore\Superadmin\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use TCore\Base\Enums\Department;
use TCore\Support\Http\Requests\Request;

class TeamRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'department' => ['required', new Enum(Department::class)],
            'leader_id' => ['nullable', 'exists:App\Models\Admin,id'],
            'member' => ['nullable', 'array'],
            'member.*' => ['nullable', 'exists:App\Models\Admin,id']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Team,id'],
            'name' => ['required', 'string'],
            'department' => ['required', new Enum(Department::class)],
            'leader_id' => ['nullable', 'exists:App\Models\Admin,id'],
            'member' => ['nullable', 'array'],
            'member.*' => ['nullable', 'exists:App\Models\Admin,id']
        ];
    }
}
<?php

namespace TCore\Superadmin\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\SuperDepartment;
use TCore\Support\Http\Requests\Request;

class AdminRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'admin.email' => ['required', 'email', 'unique:TCore\Superadmin\Models\Admin,email'],
            'admin.fullname' => ['required', 'string'],
            'admin.phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:TCore\Superadmin\Models\Admin,phone'],
            'admin.salary' => ['nullable', 'numeric', 'min:0'],
            'admin.password' => ['required', 'string', 'confirmed'],
            'admin.birthday' => ['nullable', 'date_format:Y-m-d'],
            'admin.is_superadmin' => ['nullable', 'boolean'],
            'admin.super_department' => ['nullable', new Enum(SuperDepartment::class)],
            'bank_account' => ['nullable', 'array'],
            'bank_account.bank_id' => ['nullable', 'exists:App\Models\Bank,id'],
            'bank_account.account_number' => ['nullable', 'string'],
            'bank_account.account_holder' => ['nullable', 'string'],
            'department' => ['nullable', 'array'],
            'department.*' => ['nullable', new Enum(Department::class)]
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:TCore\Superadmin\Models\Admin,id'],
            'admin.email' => ['required', 'email', 'unique:TCore\Superadmin\Models\Admin,email,'.$this->id],
            'admin.fullname' => ['required', 'string'],
            'admin.phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:TCore\Superadmin\Models\Admin,phone,'.$this->id],
            'admin.salary' => ['nullable', 'numeric', 'min:0'],
            'admin.password' => ['nullable', 'string', 'confirmed'],
            'admin.birthday' => ['nullable', 'date_format:Y-m-d'],
            'admin.is_superadmin' => ['nullable', 'boolean'],
            'admin.super_department' => ['nullable', new Enum(SuperDepartment::class)],
            'bank_account' => ['nullable', 'array'],
            'bank_account.bank_id' => ['nullable', 'exists:App\Models\Bank,id'],
            'bank_account.account_number' => ['nullable', 'string'],
            'bank_account.account_holder' => ['nullable', 'string'],
            'department' => ['nullable', 'array'],
            'department.*' => ['nullable', new Enum(Department::class)]
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        
    }
}
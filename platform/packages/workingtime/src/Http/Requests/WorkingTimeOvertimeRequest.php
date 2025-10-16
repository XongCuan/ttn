<?php

namespace TCore\WorkingTime\Http\Requests;

use TCore\Support\Http\Requests\Request;

class WorkingTimeOvertimeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'admin_id' => ['required', 'exists:App\Models\Admin,id'],
            'type_overtime_id' => ['required', 'exists:App\Models\TypeOvertime,id'],
            'date' => ['required', 'string'],
            'hour' => ['required'], 
            'note' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\WorkingOvertime,id'],
            'admin_id' => ['required', 'exists:App\Models\Admin,id'],
            'type_overtime_id' => ['required', 'exists:App\Models\TypeOvertime,id'],
            'date' => ['required', 'string'],
            'hour' => ['required'], 
            'note' => ['nullable']
        ];
    }
}

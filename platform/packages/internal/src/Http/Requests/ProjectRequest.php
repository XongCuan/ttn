<?php

namespace TCore\Internal\Http\Requests;

use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectStatus;
use Illuminate\Validation\Rules\Enum;
use TCore\Support\Http\Requests\Request;

class ProjectRequest extends Request
{
    protected function methodPost()
    {
        return [
            'order_id' => ['nullable', 'exists:App\Models\Order,id'],
            'name' => ['required'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'desc' => ['nullable'],
            'priority' => ['nullable', new Enum(ProjectPriority::class)],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id']
        ];
    }

    protected function methodPut()
    {
        if ($this->routeIs('internal.project.update_change_status')) {
            return [
                'id' => ['required', 'exists:App\Models\Project,id'],
                'status' => ['required', new Enum(ProjectStatus::class)],
            ];
        }
        return [
            'id' => ['required', 'exists:App\Models\Project,id'],
            'name' => ['required'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'desc' => ['nullable'],
            'priority' => ['nullable', new Enum(ProjectPriority::class)],
            'status' => ['nullable', new Enum(ProjectStatus::class)],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id']
        ];
    }
}
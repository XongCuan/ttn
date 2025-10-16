<?php

namespace TCore\Webadmin\Http\Requests;

use App\Enums\Project\ProjectRequirementStatus;
use Illuminate\Validation\Rules\Enum;
use TCore\Support\Http\Requests\Request;

class PRequirementRequest extends Request
{
    protected function methodPost()
    {
        return [
            'order_id' => ['nullable', 'exists:App\Models\Order,id'],
            'title' => ['required'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'content' => ['nullable'],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigned_by' => ['nullable', 'exists:App\Models\Admin,id']
        ];
    }

    protected function methodPut()
    {
        if ($this->routeIs('webadmin.project_requirement.update_change_status')) {
            return [
                'id' => ['required', 'exists:TCore\Webadmin\Models\PRequirement,id'],
                'status' => ['required', new Enum(ProjectRequirementStatus::class)],
            ];
        }elseif($this->routeIs('webadmin.project_requirement.handle_confirm_demo')) {

            return [
                'id' => ['required', 'exists:TCore\Webadmin\Models\PRequirement,id'],
            ];
        }

        return [
            'id' => ['required', 'exists:App\Models\Project,id'],
            'title' => ['required'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'content' => ['nullable'],
            'status' => ['nullable', new Enum(ProjectRequirementStatus::class)],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigned_by' => ['nullable', 'exists:App\Models\Admin,id']
        ];
    }
}
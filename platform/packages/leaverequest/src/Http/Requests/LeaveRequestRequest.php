<?php

namespace TCore\LeaveRequest\Http\Requests;

use App\Models\Setting;
use Carbon\Carbon;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\Support\Http\Requests\Request;

class LeaveRequestRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'title' => ['nullable'],
            'type' => ['nullable'],
            'is_half_day' => ['nullable'],
            'half_day_type' => ['nullable'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'file' => ['nullable'],
            'reason' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\LeaveRequest,id'],
            'reason_rejection' => ['nullable']
        ];
    }
}

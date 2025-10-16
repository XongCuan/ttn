<?php

namespace TCore\WorkingTime\Http\Requests;

use App\Models\Setting;
use Carbon\Carbon;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\Support\Http\Requests\Request;

class WorkingTimeRequest extends Request
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
            'date' => ['required', 'date_format:Y-m-d'],
            'check_in' => ['required', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable'],
            'note' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\WorkingTime,id'],
            'date' => ['required', 'date_format:Y-m-d'],
            'check_in' => ['required', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable'],
            'note' => ['nullable']
        ];
    }


    public function prepareForValidation()
    {
        $checkIn = $this->input('check_in');
        if ($checkIn) {
            $startWorkingTime = Setting::getValue('start_working_time');
            $almostOnTimeWorkingTime = Setting::getValue('almost_ontime_working_time');

            $checkInTime = Carbon::createFromFormat('H:i', $checkIn);
            $startTime = Carbon::createFromFormat('H:i', $startWorkingTime);
            $almostOnTime = Carbon::createFromFormat('H:i', $almostOnTimeWorkingTime);

            $status = $checkInTime->lte($startTime) ? WorkingTimeStatus::OnTime->value : ($checkInTime->lte($almostOnTime) ? WorkingTimeStatus::AlmostOnTime->value : WorkingTimeStatus::Late->value);

            $this->merge(['status' => $status]);
        }
    }
}

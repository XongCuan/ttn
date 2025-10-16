<?php

namespace TCore\WorkingTime\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use TCore\Support\Http\Requests\Request;
use TCore\WorkingTime\Enums\WorkingTimeTicketType;

class WorkingTimeTicketRequest extends Request
{
    protected function methodPost()
    {
        return [
            'ticket_date' => ['required', 'date_format:Y-m-d'],
            'type' => ['required', new Enum(WorkingTimeTicketType::class)],
            'attachment_path' => ['nullable'],
            'reason' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\WorkingTimeTicket,id'],
            'ticket_date' => ['required', 'date_format:Y-m-d'],
            'type' => ['required', new Enum(WorkingTimeTicketType::class)],
            'attachment_path' => ['nullable'],
            'reason' => ['nullable']
        ];
    }
}
<?php

namespace TCore\Sales\Http\Requests;

use App\Enums\Area;
use App\Enums\Contact\ContactStatus;
use Illuminate\Validation\Rules\Enum;
use TCore\Base\Enums\Gender;
use TCore\Support\Http\Requests\Request;

class ContactRequest extends Request
{
    protected function methodPost()
    {
        return [
            'fullname' => ['required', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'], 
            'email' => ['nullable', 'email'],
            'gender' => ['required', new Enum(Gender::class)],
            'created_at' => ['nullable', 'date:Y-m-d'],
            'source_id' => ['nullable', 'exists:App\Models\Source,id'],
            'type_id' => ['nullable', 'exists:App\Models\ContactType,id'],
            'status' => ['required', new Enum(ContactStatus::class)],
            'area' => ['required', new Enum(Area::class)],
            'sector_id' => ['nullable', 'exists:App\Models\Sector,id'],
            'range_price_id' => ['nullable', 'exists:App\Models\RangePrice,id'],
            'province_code' => ['nullable', 'exists:TCore\Base\Models\Province,code'],
            'district_code' => ['nullable', 'exists:TCore\Base\Models\District,code'],
            'ward_code' => ['nullable', 'exists:TCore\Base\Models\Ward,code'],
            'address' => ['nullable'],
            'note' => ['nullable'],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Contact,id'],
            'fullname' => ['required', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'], 
            'email' => ['nullable', 'email'],
            'gender' => ['required', new Enum(Gender::class)],
            'created_at' => ['nullable', 'date:Y-m-d'],
            'source_id' => ['nullable', 'exists:App\Models\Source,id'],
            'type_id' => ['nullable', 'exists:App\Models\ContactType,id'],
            'status' => ['required', new Enum(ContactStatus::class)],
            'area' => ['required', new Enum(Area::class)],
            'sector_id' => ['nullable', 'exists:App\Models\Sector,id'],
            'range_price_id' => ['nullable', 'exists:App\Models\RangePrice,id'],
            'province_code' => ['nullable', 'exists:TCore\Base\Models\Province,code'],
            'district_code' => ['nullable', 'exists:TCore\Base\Models\District,code'],
            'ward_code' => ['nullable', 'exists:TCore\Base\Models\Ward,code'],
            'address' => ['nullable'],
            'note' => ['nullable'],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id']
        ];
    }
}
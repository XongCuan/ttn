<?php

namespace TCore\Sales\Http\Requests;

use App\Enums\Area;
use Illuminate\Validation\Rules\Enum;
use TCore\Base\Enums\Gender;
use TCore\Base\Enums\Status;
use TCore\Support\Http\Requests\Request;

class EnqRequest extends Request
{
    protected function methodPost()
    {
        return [
            'fullname' => ['nullable', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'],
            'email' => ['nullable', 'email'],
            'gender' => ['nullable', new Enum(Gender::class)],
            'status' => ['nullable', new Enum(Status::class)],
            'created_at' => ['nullable', 'date:Y-m-d'],
            'source_id' => ['nullable', 'exists:App\Models\Source,id'],
            'area' => ['nullable', new Enum(Area::class)],
            'sector_id' => ['nullable', 'exists:App\Models\Sector,id'],
            'range_price_id' => ['nullable', 'exists:App\Models\RangePrice,id'],
            'province_code' => ['nullable', 'exists:TCore\Base\Models\Province,code'],
            'district_code' => ['nullable', 'exists:TCore\Base\Models\District,code'],
            'ward_code' => ['nullable', 'exists:TCore\Base\Models\Ward,code'],
            'address' => ['nullable'],
            'note' => ['nullable'],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id'],

            // ✅ Thêm mới
            'company' => ['nullable', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:255'],
            'tax_code' => ['nullable', 'string', 'max:50'],
            'customer_type' => ['nullable', 'string', 'max:100'],
            'customer_id' => 'nullable|exists:customers,id',

        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Enq,id'],
            'fullname' => ['nullable', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'],
            'email' => ['nullable', 'email'],
            'gender' => ['nullable', new Enum(Gender::class)],
            'status' => ['nullable', new Enum(Status::class)],
            'created_at' => ['nullable', 'date:Y-m-d'],
            'source_id' => ['nullable', 'exists:App\Models\Source,id'],
            'area' => ['nullable', new Enum(Area::class)],
            'sector_id' => ['nullable', 'exists:App\Models\Sector,id'],
            'range_price_id' => ['nullable', 'exists:App\Models\RangePrice,id'],
            'province_code' => ['nullable', 'exists:TCore\Base\Models\Province,code'],
            'district_code' => ['nullable', 'exists:TCore\Base\Models\District,code'],
            'ward_code' => ['nullable', 'exists:TCore\Base\Models\Ward,code'],
            'address' => ['nullable'],
            'note' => ['nullable'],
            'team_id' => ['nullable', 'exists:App\Models\Team,id'],
            'assigns' => ['nullable', 'array'],
            'assigns.*' => ['nullable', 'exists:TCore\Sales\Models\Employee,id'],

            // ✅ Thêm mới
            'company' => ['nullable', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:255'],
            'tax_code' => ['nullable', 'string', 'max:50'],
            'customer_type' => ['nullable', 'string', 'max:100'],
            'customer_id' => 'nullable|exists:customers,id',
        ];
    }
}

<?php

namespace TCore\Auth\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use TCore\Base\Enums\Gender;
use TCore\Support\Http\Requests\Request;

class ProfileRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        if($this->routeIs('auth.profile.update_location')) {
            return [
                'latitude' => ['nullable', 'numeric', 'min:-90', 'max:90'],
                'longitude' => ['nullable', 'numeric', 'min:-180', 'max:180']
            ];
        }

        return [
            'fullname' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:TCore\Superadmin\Models\Admin,phone,'.get_auth_admin()->id],
            'birthday' => ['nullable', 'date_format:Y-m-d'],
            'gender' => ['nullable', new Enum(Gender::class)]
        ];
    }
}
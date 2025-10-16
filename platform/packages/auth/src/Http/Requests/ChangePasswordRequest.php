<?php

namespace TCore\Auth\Http\Requests;

use TCore\Support\Http\Requests\Request;

class ChangePasswordRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut()
    {
        return [
            'old_password' =>['current_password:admin'],
            'password' => ['required', 'string', 'max:255', 'confirmed'],
        ];
    }
}
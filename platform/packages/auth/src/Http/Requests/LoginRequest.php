<?php

namespace TCore\Auth\Http\Requests;

use TCore\Support\Http\Requests\Request;

class LoginRequest extends Request
{
    protected function methodPost()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
}
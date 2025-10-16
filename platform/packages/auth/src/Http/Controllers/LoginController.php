<?php

namespace TCore\Auth\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use TCore\Auth\Http\Requests\LoginRequest;
use TCore\Base\Http\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        return view('packages_auth::login');
    }

    public function handle(LoginRequest $request)
    {
        if($this->resolve($request->validated()))
        {
            $request->session()->regenerate();
            
            return utilities()->toRoute('dashboard.index');
        }

        return utilities()->responseBack(error: true, msg: trans('Email hoặc mật khẩu không chính xác'), withInput: true);
    }

    protected function resolve($data): bool
    {
        return Auth::guard('admin')->attempt($data, true) ? true : false;
    }
}

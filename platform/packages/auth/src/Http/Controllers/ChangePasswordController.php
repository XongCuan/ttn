<?php

namespace TCore\Auth\Http\Controllers;

use Illuminate\View\View;
use TCore\Auth\Http\Requests\ChangePasswordRequest;
use Theme\Cms\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function index(): View
    {
        return view('packages_auth::change-password', [
            'breadcrumbs' => $this->breadcrumbs()->add(__('Đổi mật khẩu'))
        ]);
    }

    public function update(ChangePasswordRequest $request)
    {
        get_auth_admin()->update([
            'password' => $request->input('password')
        ]);
        
        return utilities()->responseBack();
    }
}

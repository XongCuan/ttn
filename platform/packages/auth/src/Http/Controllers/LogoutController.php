<?php

namespace TCore\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use TCore\Base\Http\Controllers\BaseController;

class LogoutController extends BaseController
{
    //
    public function logout(Request $request): RedirectResponse
    {
        auth('admin')->logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return utilities()->toRoute(name: 'login.index');
    }
}

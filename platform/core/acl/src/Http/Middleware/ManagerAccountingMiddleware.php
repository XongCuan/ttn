<?php

namespace TCore\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerAccountingMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::guard('admin')->check())
        {
            if (get_auth_admin()->hasManagerShipRoleAccounting())
            {
                return $next($request);
            }
            return abort(403);
        }

        return redirect()->guest(route('login.index'))->with('warning', __('pleaseLogin'));
    }
}
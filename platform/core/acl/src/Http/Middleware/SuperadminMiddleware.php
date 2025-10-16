<?php

namespace TCore\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Perform action
        if (Auth::guard('admin')->check())
        {
            if(Auth::guard('admin')->user()->isSuperadmin())
            {
                return $next($request);
            }
            
            return abort(403);
        }

        return redirect()->guest(route('login.index'))->with('warning', __('pleaseLogin'));
    }
}
<?php

namespace TCore\Base\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CKFinderAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $configCkfinder = [
            'ckfinder.authentication' => function() {return true;}
        ];

        $resourceTypes = config('ckfinder.resourceTypes');

        if(get_auth_admin()->isSuperadmin() == false)
        {
            unset($resourceTypes[3]);
        }

        if(url()->previous() == route('superadmin.ckfinder'))
        {
            unset($resourceTypes[0], $resourceTypes[1], $resourceTypes[2]);
        }

        $configCkfinder = array_merge($configCkfinder, [
            'ckfinder.resourceTypes' => $resourceTypes
        ]);

        config($configCkfinder);

        return $next($request);
    }
}

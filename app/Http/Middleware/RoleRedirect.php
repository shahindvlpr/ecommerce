<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check())
        {
            $user = auth()->user();

            if($user->hasRole('Super Admin') || $user->hasRole('Admin'))
            {
                return redirect()->route('admin.dashboard');
            }

            if($user->hasRole('Vendor'))
            {
                return redirect()->route('vendor.dashboard');
            }

            if($user->hasRole('Customer'))
            {
                return redirect()->route('customer.dashboard');
            }
        }

        return $next($request);
    }
}
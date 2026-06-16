<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Allow if user is vendor or admin
        if ($user->role === 'vendor' || $user->is_admin || $user->role === 'admin') {
            return $next($request);
        }

        abort(403, 'You do not have vendor access.');
    }
}
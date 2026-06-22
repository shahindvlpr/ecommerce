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

        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized - Vendor access required.');
        }

        if ($user->role === 'vendor' && !$user->is_vendor_approved) {
            abort(403, 'Your vendor account is pending approval. Please wait for admin approval.');
        }

        return $next($request);
    }
}
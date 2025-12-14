<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Auth debug', [
            'check' => Auth::guard('web')->check(),
            'user' => Auth::guard('web')->user(),
            'session' => session()->all()
        ]);

        if (!Auth::guard('web')->check()) {
            $notification = [
                'message' => 'Please log in to access.',
                'alert-type' => 'error'
            ];

            return redirect()
                ->route('login-admin')
                ->with($notification);
        }

        $user = Auth::guard('web')->user();

        if ($user->role !== 'super_admin' || $user->user_type_id != 1) {
            $notification = [
                'message' => 'Unauthorized access. Only Super Admins can access this area.',
                'alert-type' => 'error'
            ];

            return redirect()
                ->route('login-admin')
                ->with($notification);
        }

        return $next($request);
    }
}

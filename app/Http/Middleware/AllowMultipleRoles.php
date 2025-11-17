<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowMultipleRoles
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Sanctum-compatible authentication check
        $user = $request->user(); // VERY IMPORTANT

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.',
                'error_code' => 'AUTH_REQUIRED'
            ], 401);
        }

        // Get the user role from database
        $userRole = $user->role; // keep your existing column

        // Role check
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Error messages
        $messages = [
            'owner' => 'This feature is only available for hotel owners.',
            'receptionist' => 'This feature is only available for receptionists.',
            'user' => 'This feature is only available for customers.',
        ];

        if (count($roles) === 1 && isset($messages[$roles[0]])) {
            $message = $messages[$roles[0]];
        } else {
            $rolesText = implode(' or ', array_map('ucfirst', $roles));
            $message = "Access restricted to {$rolesText} only.";
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized.' . $message,
            'your_role' => ucfirst($userRole),
        ], 403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Filament\Notifications\Notification;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        
        // Admin can access everything
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Check if user's role is in the allowed roles
        if (!in_array($user->role, $roles)) {
            // Send notification before logout
            Notification::make()
                ->danger()
                ->title('Unauthorized Access')
                ->body('You do not have permission to access this area. You have been logged out.')
                ->persistent()
                ->send();
            
            // Clear session and logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect to appropriate panel
            $redirectUrl = match($user->role) {
                'marketing' => '/marketing',
                'sales' => '/sales',
                default => '/admin',
            };
            
            return redirect($redirectUrl);
        }

        return $next($request);
    }
}
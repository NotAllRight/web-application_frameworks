<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoles
{
    public function handle($request, Closure $next, ...$roles)
    {
        $userInfo = $request->attributes->get('user_info');
        $userRoles = $userInfo['roles'] ?? [];

        \Log::debug('User roles check', [
            'userRoles' => $userRoles,
            'requiredRoles' => $roles
        ]);

        // Проверяем пересечение ролей
        if (empty(array_intersect($userRoles, $roles))) {
            \Log::error('Forbidden: User does not have required roles', [
                'userRoles' => $userRoles,
                'requiredRoles' => $roles
            ]);
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}

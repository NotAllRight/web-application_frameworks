<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\Http;

// class KeycloakMiddleware
// {
//     public function handle($request, Closure $next)
//     {
//         $token = $request->bearerToken();

//         if (!$token) {
//             return response()->json(['error' => 'Token not provided'], 401);
//         }

//         \Log::debug('Received Token:', ['token' => $token]);

//         // Проверяем токен и получаем информацию о пользователе из Keycloak
//         $response = Http::withHeaders([
//             'Authorization' => 'Bearer ' . $token,
//         ])->get(config('services.keycloak.base_url') . '/realms/' . config('services.keycloak.realm') . '/protocol/openid-connect/userinfo');

//         if ($response->failed()) {
//             \Log::error('Failed to fetch user info from Keycloak', [
//                 'status' => $response->status(),
//                 'response' => $response->body(),
//             ]);
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $userInfo = $response->json();

//         \Log::debug('Keycloak User Info:', ['userInfo' => $userInfo]);

//         // Извлекаем роли из ответа Keycloak, если они есть
//         $roles = $userInfo['realm_access']['roles'] ?? [];

//         // Добавляем роли в user_info
//         $userInfo['roles'] = $roles;

//         // Сохраняем информацию о пользователе в запрос
//         $request->attributes->set('user_info', $userInfo);

//         return $next($request);
//     }
// }

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class KeycloakMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        Log::debug('Received Token:', ['token' => $token]);

        // Декодируем JWT токен вручную, чтобы получить роли
        $jwt = explode('.', $token);
        if (count($jwt) != 3) {
            return response()->json(['error' => 'Invalid token format'], 401);
        }

        $payload = json_decode(base64_decode($jwt[1]), true);

        // Проверяем, есть ли в payload доступ к приложению 'php-app'
        if (!isset($payload['resource_access']['php-app']['roles'])) {
            Log::error('Roles for php-app not found in token', ['token' => $token]);
            return response()->json(['error' => 'Roles for php-app not found in token'], 401);
        }

        // Извлекаем роли из php-app
        $roles = $payload['resource_access']['php-app']['roles'];

        // Сохраняем роли в user_info
        $userInfo = $payload; // Здесь можно сохранить другие данные, если нужно
        $userInfo['roles'] = $roles;

        // Добавляем информацию о пользователе в запрос
        $request->attributes->set('user_info', $userInfo);

        return $next($request);
    }
}



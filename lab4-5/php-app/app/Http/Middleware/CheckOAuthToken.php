<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

class CheckOAuthToken
{
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->bearerToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $provider = new GenericProvider([
            'clientId'                => env('OAUTH_CLIENT_ID'),
            'clientSecret'            => env('OAUTH_CLIENT_SECRET'),
            'redirectUri'             => env('OAUTH_REDIRECT_URI'),
            'urlAuthorize'            => env('OAUTH_URL_AUTHORIZE'),
            'urlAccessToken'          => env('OAUTH_URL_ACCESS_TOKEN'),
            'urlResourceOwnerDetails' => env('OAUTH_URL_RESOURCE_OWNER_DETAILS'),
        ]);

        try {
            $token = new AccessToken(['access_token' => $accessToken]);

            // Верификация токена
            $resourceOwner = $provider->getResourceOwner($token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

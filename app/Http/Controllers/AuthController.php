<?php

namespace App\Http\Controllers;

use App\Interop\Fullteaching\FullteachingClient;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password', 'provider']);

        $user = FullteachingClient::login($credentials['email'], $credentials['password']);

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function logout(Request $request) {
        auth()->logout();

        return response()->json(['success' => true, 'message' => 'Session invalidated']);
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

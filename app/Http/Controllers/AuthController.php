<?php

namespace App\Http\Controllers;

use App\Traits\PasswordEncryper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use mysql_xdevapi\Exception;

class AuthController extends Controller
{
    use PasswordEncryper;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = [
            'login' => request()->get('login'),
            'password' => $this->passwordEncryper(request()->get('password'))
        ];

        if (! $token = auth()->attempt($credentials, true)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, Auth()->user()->login);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['status' => true, 'message' => 'Deslogado com sucesso!']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), Auth()->user()->login);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $login)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'login' => $login
        ]);
    }

    public function checkAccess() {
        try {
            return response()->json(['valid' => auth()->check()]);
        } catch (\Exception $e) {
            return response()->json(['valid' => false]);
        }
    }
}

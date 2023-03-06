<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        try {
            if (! $token = Auth::attempt($credentials)) {
                return response()->format(Response::HTTP_INTERNAL_SERVER_ERROR, 'Login Failed');
            }

            return response()->format(
                Response::HTTP_OK,
                'Login Success',
                ['token' => $token, 'user' => auth()->user()]
            );
        } catch (Exception $e) {
            return response()->format(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();

        return response()->format(Response::HTTP_OK, 'Logout Success');
    }
}

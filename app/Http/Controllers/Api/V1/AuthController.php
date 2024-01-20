<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Requests\Api\V1\ResetPasswordRequest;
use App\Services\Interfaces\AuthenticationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @param AuthenticationInterface $auth
     *
     * @return void
     */
    public function __construct(private AuthenticationInterface $auth)
    {
        //
    }


    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->auth->login(
            email: $request->validated('email'),
            password: $request->validated('password'),
            remember: $request->has('remember')
        );
    }


    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->auth->register(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }


    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        return $this->auth->forgotPassword(email: $request->validated('email'));
    }


    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->auth->resetPassword(
            email: $request->validated('email'),
            password: $request->validated('password'),
            passwordConfirmation: $request->validated('password_confirmation'),
            token: $request->validated('token')
        );
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->auth->logout();
    }
}

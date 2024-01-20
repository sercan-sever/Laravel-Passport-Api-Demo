<?php

namespace App\Services\Interfaces;

use Illuminate\Http\JsonResponse;

interface AuthenticationInterface
{
    /**
     * @param string $email
     * @param string $password
     * @param bool $remember
     *
     * @return JsonResponse
     */
    public function login(string $email, string $password, bool $remember = false): JsonResponse;


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    public function register(string $name, string $email, string $password): JsonResponse;


    /**
     * @param string $email
     *
     * @return JsonResponse
     */
    public function forgotPassword(string $email): JsonResponse;


    /**
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @param string $token
     *
     * @return JsonResponse
     */
    public function resetPassword(string $email, string $password, string $passwordConfirmation, string $token): JsonResponse;


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse;
}

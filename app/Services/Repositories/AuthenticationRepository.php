<?php

namespace App\Services\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Interfaces\AuthenticationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthenticationRepository extends UserRepository implements AuthenticationInterface
{
    /**
     * @param string $email
     * @param string $password
     * @param bool $remember
     *
     * @return JsonResponse
     */
    public function login(string $email, string $password, bool $remember = false): JsonResponse
    {
        if (Auth::attempt(['email' => $email, 'password' => passwordGeneration(password: $password)], $remember)) {

            $token = auth()->user()->createToken('ApiDemo')->accessToken;

            return response()->json(["data" => ['user' => new UserResource(resource: auth()->user()), 'token' => $token], 'message' => "Başarıyla Giriş Yapıldı."], Response::HTTP_OK);
        }

        return response()->json(['message' => "Böyle Bir Kullanıcı Bulunamadı !!!"], Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    public function register(string $name, string $email, string $password): JsonResponse
    {
        $user = $this->create(name: $name, email: $email, password: $password);

        if (is_null($user)) {
            return response()->json(['message' => 'Kullanıcı Kaydı Başarısız Bilgileri Kontrol Ederek Tekrar Deneyiniz !!!'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->login(email: $user?->email, password: $password);
    }


    /**
     * @param string $email
     *
     * @return JsonResponse
     */
    public function forgotPassword(string $email): JsonResponse
    {
        $user = $this->getByEmail(email: $email);

        if (is_null($user)) {
            return response()->json(['message' => 'Böyle Bir Kullanıcı Bulunamadı !!!'], Response::HTTP_UNAUTHORIZED);
        }

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {

            return response()->json(['message' => "Mailinizi Kontrol Ediniz."], Response::HTTP_OK);
        }

        return response()->json(['message' => "Bir Sorun Oluştu Tekrar Deneyiniz ( " . $status . " )"], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @param string $token
     *
     * @return JsonResponse
     */
    public function resetPassword(string $email, string $password, string $passwordConfirmation, string $token): JsonResponse
    {
        $status = Password::reset(
            [
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $passwordConfirmation,
                'token' => $token
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make(passwordGeneration(password: $password))
                ]);

                $user->save();
            }
        );


        if ($status === Password::PASSWORD_RESET) {

            return response()->json(['message' => "Şifreniz Başarıyla Güncellenmiştir."], Response::HTTP_OK);
        }

        return response()->json(['message' => "Bir Sorun Oluştu Tekrar Deneyiniz ( " . $status . " )"], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => "Başarıyla Çıkış Yapılmıştır."], Response::HTTP_OK);
    }
}

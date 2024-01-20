<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Services\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User|null
     */
    public function create(string $name, string $email, string $password): ?User
    {
        return User::query()->create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make(value: passwordGeneration(password: $password))
        ]);
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return User::query()->whereEmail($email)->first();
    }
}

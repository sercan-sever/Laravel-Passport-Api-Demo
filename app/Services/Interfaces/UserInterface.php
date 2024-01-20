<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface UserInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User|null
     */
    public function create(string $name, string $email, string $password): ?User;


    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User;
}

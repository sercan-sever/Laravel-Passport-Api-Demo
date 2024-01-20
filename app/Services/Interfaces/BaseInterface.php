<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function getById(int $id): ?Model;
}

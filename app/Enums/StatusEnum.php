<?php

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum StatusEnum: string
{
    use EnumValuesTrait;

    case A = 'a';
    case P = 'p';

    /**
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::A => 'Aktif',
            self::P => 'Pasif',
        };
    }
}

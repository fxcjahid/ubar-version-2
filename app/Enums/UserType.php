<?php

/**
 * Summary of namespace App\Enums
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class UserType
{
    public const ADMIN  = 'admin';
    public const USER   = 'user';
    public const DRIVER = 'driver';

    public static function values() : array
    {
        return [
            self::ADMIN,
            self::USER,
            self::DRIVER,
        ];
    }
}
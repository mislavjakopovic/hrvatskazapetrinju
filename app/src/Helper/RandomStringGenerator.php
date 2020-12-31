<?php

declare(strict_types=1);

namespace App\Helper;

class RandomStringGenerator
{
    protected const SEED = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generate($length = 8)
    {
        return substr(str_shuffle(str_repeat(self::SEED, (int)ceil($length / strlen(self::SEED)))), 1, $length);
    }
}

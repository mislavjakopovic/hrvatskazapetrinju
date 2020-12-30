<?php

declare(strict_types=1);

namespace App\Enum;

class PostIntentEnum
{
    public const LOOKING = 'looking';
    public const OFFERING = 'offering';

    public static function getAvailableIntents()
    {
        return [
            self::LOOKING,
            self::OFFERING,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Enum;

class PostTypeEnum
{
    public const LOOKING = 'looking';
    public const OFFERING = 'offering';

    public static function getAvailableTypes()
    {
        return [
            self::LOOKING,
            self::OFFERING,
        ];
    }
}

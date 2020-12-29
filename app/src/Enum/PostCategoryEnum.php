<?php

declare(strict_types=1);

namespace App\Enum;

class PostCategoryEnum
{
    public const SUPPLIES = 'supplies';
    public const TRANSPORTATION = 'transportation';
    public const RESIDENCY = 'residency';

    public const LOOKING_CATEGORIES = [
        self::SUPPLIES,
        self::TRANSPORTATION,
        self::RESIDENCY,
    ];

    public const OFFERING_CATEGORIES = [
        self::SUPPLIES,
        self::TRANSPORTATION,
        self::RESIDENCY,
    ];
}

<?php

declare(strict_types=1);

namespace App\Enum;

class PostCategoryEnum
{
    public const RESIDENCY = 'residency';
    public const SUPPLIES = 'supplies';
    public const TRANSPORTATION = 'transportation';
    public const OTHER = 'other';

    public const INTENT_CATEGORIES = [
        PostIntentEnum::LOOKING => [
            self::SUPPLIES,
            self::TRANSPORTATION,
            self::RESIDENCY,
            self::OTHER,
        ],
        PostIntentEnum::OFFERING => [
            self::SUPPLIES,
            self::TRANSPORTATION,
            self::RESIDENCY,
            self::OTHER,
        ]
    ];
}

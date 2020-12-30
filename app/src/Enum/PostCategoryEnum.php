<?php

declare(strict_types=1);

namespace App\Enum;

class PostCategoryEnum
{
    public const RESIDENCY = 'residency';
    public const SUPPLIES = 'supplies';
    public const TRANSPORTATION = 'transportation';

    public const INTENT_CATEGORIES = [
        PostIntentEnum::LOOKING => [
            self::SUPPLIES,
            self::TRANSPORTATION,
            self::RESIDENCY,
        ],
        PostIntentEnum::OFFERING => [
            self::SUPPLIES,
            self::TRANSPORTATION,
            self::RESIDENCY,
        ]
    ];
}

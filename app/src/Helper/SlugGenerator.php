<?php

namespace App\Helper;

class SlugGenerator
{
    public static function generate(string $text): string
    {
        return preg_replace('/\s+/', '-', mb_strtolower(trim(strip_tags($text)), 'UTF-8'));
    }
}

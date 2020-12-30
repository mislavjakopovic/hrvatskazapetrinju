<?php

namespace App\Twig;

use Carbon\Carbon;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CarbonExtension extends AbstractExtension
{
    public function __construct()
    {
        Carbon::setLocale('hr');
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('elapsed', [$this, 'elapsed']),
        ];
    }

    public function elapsed(\DateTimeInterface $dateTime): string
    {
        $now = Carbon::now();
        $interval = $now->diffAsCarbonInterval($dateTime);

        return $now->sub($interval)->diffForHumans();
    }
}

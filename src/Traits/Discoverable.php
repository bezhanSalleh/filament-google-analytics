<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

trait Discoverable
{
    protected static bool $isDiscovered = true;

    public static function isDiscovered(): bool
    {
        static::$isDiscovered = static::canView();

        return static::$isDiscovered;
    }
}

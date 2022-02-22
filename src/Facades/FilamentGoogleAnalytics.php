<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics
 */
class FilamentGoogleAnalytics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-google-analytics';
    }
}

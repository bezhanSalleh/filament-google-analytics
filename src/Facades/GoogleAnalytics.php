<?php

namespace BezhanSalleh\GoogleAnalytics\Facades;

use BezhanSalleh\GoogleAnalytics\GoogleAnalytics as FilamentGoogleAnalytics;
use Illuminate\Support\Facades\Facade;

/**
 * @method static thousandsFormater()
 * @method static for()
 *
 * @see FilamentGoogleAnalytics
 */
class GoogleAnalytics extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FilamentGoogleAnalytics::class;
    }
}

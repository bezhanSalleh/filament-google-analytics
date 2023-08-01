<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Facades;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics as FGA;
use Illuminate\Support\Facades\Facade;

/**
 * @method static thousandsFormater()
 * @method static for()
 *
 * @see \BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics
 */
class FilamentGoogleAnalytics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FGA::class;
    }
}

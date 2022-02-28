<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Facades;

use Illuminate\Support\Facades\Facade;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics as FGA;

/**
 * @method static thousandsFormater()
 * @see \BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics
 */
class FilamentGoogleAnalytics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FGA::class;
    }
}

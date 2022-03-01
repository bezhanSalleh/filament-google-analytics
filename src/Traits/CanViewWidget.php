<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Illuminate\Support\Str;

trait CanViewWidget
{
    public static function canView(): bool
    {
        $filamentDashboardStatus = config('filament-google-analytics.' . Str::of(static::class)->after('Widgets\\')->before('Widget')->snake().'.filament_dashboard');

        $globalStatus = config('filament-google-analytics.' . Str::of(static::class)->after('Widgets\\')->before('Widget')->snake().'.global');

        if ($filamentDashboardStatus && request()->routeIs('filament.pages.dashboard'))
        {
            return true;
        }

        if ($globalStatus && config('filament-google-analytics.dedicated_dashboard') && request()->routeIs('filament.pages.filament-google-analytics-dashboard'))
        {
            return true;
        }

        if ($globalStatus && !$filamentDashboardStatus && !request()->routeIs('filament.pages.dashboard') && !request()->routeIs('filament.pages.filament-google-analytics-dashboard'))
        {
            return true;
        }

        return false;
    }
}

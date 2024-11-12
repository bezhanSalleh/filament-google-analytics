<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Illuminate\Support\Str;

trait CanViewWidget
{
    public static function canView(): bool
    {
        $filamentPagesRoutePrefix = 'filament.' . filament()->getCurrentPanel()->getId() . '.pages.';
        $filamentDashboardStatus = config('filament-google-analytics.' . Str::of(static::class)->after('Widgets\\')->before('Widget')->snake() . '.filament_dashboard');

        $globalStatus = config('filament-google-analytics.' . Str::of(static::class)->after('Widgets\\')->before('Widget')->snake() . '.global');

        if ($filamentDashboardStatus && request()->routeIs($filamentPagesRoutePrefix . 'dashboard')) {
            return true;
        }

        if ($globalStatus && config('filament-google-analytics.dedicated_dashboard') && request()->routeIs($filamentPagesRoutePrefix . 'filament-google-analytics-dashboard')) {
            return true;
        }

        if ($globalStatus && ! request()->routeIs($filamentPagesRoutePrefix . 'dashboard') && ! request()->routeIs($filamentPagesRoutePrefix . 'filament-google-analytics-dashboard')) {
            return true;
        }

        return false;
    }
}

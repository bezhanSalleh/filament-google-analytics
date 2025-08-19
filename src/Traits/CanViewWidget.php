<?php

namespace BezhanSalleh\GoogleAnalytics\Traits;

use Illuminate\Support\Str;

trait CanViewWidget
{
    public static function canView(): bool
    {
        $panel = filament()->getCurrentOrDefaultPanel();
        $panelPrefix = 'filament.' . $panel?->getId() . '.pages.';

        $configKey = Str::of(static::class)->after('Widgets\\')->before('Widget')->snake()->toString();
        if (blank($configKey)) {
            return false; // unknown widget, hide by default
        }

        $widgetConfig = config('google-analytics.' . $configKey, [
            'filament_dashboard' => false,
            'global' => false,
        ]);

        $filamentDashboardStatus = $widgetConfig['filament_dashboard'] ?? false;
        $globalStatus = $widgetConfig['global'] ?? false;
        $dedicatedDashboardEnabled = config('google-analytics.dedicated_dashboard', false);

        // Show on default Filament dashboard
        if ($filamentDashboardStatus && request()->routeIs($panelPrefix . 'dashboard')) {
            return true;
        }

        // Show on dedicated GA dashboard
        if ($globalStatus && $dedicatedDashboardEnabled && request()->routeIs($panelPrefix . 'google-analytics-dashboard')) {
            return true;
        }

        // Show globally on any other panel pages
        return $globalStatus && ! request()->routeIs([
            $panelPrefix . 'dashboard',
            $panelPrefix . 'google-analytics-dashboard',
        ]);
    }
}

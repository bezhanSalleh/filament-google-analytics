<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GAActiveUsersOneDayOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GAActiveUsersSevenDayOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GAActiveUsersTwentyEightDayOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GAMostVisitedPagesList;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GAPageViewsOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GASessionsByCountryOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GASessionsByDeviceOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GASessionsDurationOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GASessionsOverview;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GATopReferrersList;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GAUniqueVisitorsOverview;

trait CanViewWidget
{
    /**
     * @var array<class-string, string>
     */
    protected static array $widgetConfigMap = [
        GAPageViewsOverview::class => 'page_views',
        GAUniqueVisitorsOverview::class => 'visitors',
        GAActiveUsersOneDayOverview::class => 'active_users_one_day',
        GAActiveUsersSevenDayOverview::class => 'active_users_seven_day',
        GAActiveUsersTwentyEightDayOverview::class => 'active_users_twenty_eight_day',
        GASessionsOverview::class => 'sessions',
        GASessionsDurationOverview::class => 'sessions_duration',
        GASessionsByCountryOverview::class => 'sessions_by_country',
        GASessionsByDeviceOverview::class => 'sessions_by_device',
        GAMostVisitedPagesList::class => 'most_visited_pages',
        GATopReferrersList::class => 'top_referrers_list',
    ];

    public static function canView(): bool
    {
        $panel = filament()->getCurrentOrDefaultPanel();
        $panelPrefix = 'filament.' . $panel?->getId() . '.pages.';

        $configKey = static::$widgetConfigMap[static::class] ?? null;
        if (! $configKey) {
            return false; // unknown widget, hide by default
        }

        $widgetConfig = config('filament-google-analytics.' . $configKey, [
            'filament_dashboard' => false,
            'global' => false,
        ]);

        $filamentDashboardStatus = $widgetConfig['filament_dashboard'] ?? false;
        $globalStatus = $widgetConfig['global'] ?? false;
        $dedicatedDashboardEnabled = config('filament-google-analytics.dedicated_dashboard', false);

        // Show on default Filament dashboard
        if ($filamentDashboardStatus && request()->routeIs($panelPrefix . 'dashboard')) {
            return true;
        }

        // Show on dedicated GA dashboard
        if ($globalStatus && $dedicatedDashboardEnabled && request()->routeIs($panelPrefix . 'filament-google-analytics-dashboard')) {
            return true;
        }

        // Show globally on any other panel pages
        return $globalStatus && ! request()->routeIs([
            $panelPrefix . 'dashboard',
            $panelPrefix . 'filament-google-analytics-dashboard',
        ]);
    }
}

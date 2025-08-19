<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics;

use BezhanSalleh\FilamentGoogleAnalytics\Pages\FilamentGoogleAnalyticsDashboard;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentGoogleAnalyticsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-google-analytics';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                FilamentGoogleAnalyticsDashboard::class,
            ])
            ->widgets([
                Widgets\GAPageViewsOverview::class,
                Widgets\GAUniqueVisitorsOverview::class,
                Widgets\GAActiveUsersOneDayOverview::class,
                Widgets\GAActiveUsersSevenDayOverview::class,
                Widgets\GAActiveUsersTwentyEightDayOverview::class,
                Widgets\GASessionsOverview::class,
                Widgets\GASessionsDurationOverview::class,
                Widgets\GASessionsByCountryOverview::class,
                Widgets\GASessionsByDeviceOverview::class,
                Widgets\GAMostVisitedPagesList::class,
                Widgets\GATopReferrersList::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

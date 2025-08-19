<?php

declare(strict_types=1);

namespace BezhanSalleh\GoogleAnalytics;

use BezhanSalleh\GoogleAnalytics\Pages\GoogleAnalyticsDashboard;
use Filament\Contracts\Plugin;
use Filament\Panel;

class GoogleAnalyticsPlugin implements Plugin
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
                GoogleAnalyticsDashboard::class,
            ])
            ->widgets([
                Widgets\PageViewsWidget::class,
                Widgets\VisitorsWidget::class,
                Widgets\ActiveUsersOneDayWidget::class,
                Widgets\ActiveUsersSevenDayWidget::class,
                Widgets\ActiveUsersTwentyEightDayWidget::class,
                Widgets\SessionsWidget::class,
                Widgets\SessionsByCountryWidget::class,
                Widgets\SessionsDurationWidget::class,
                Widgets\SessionsByDeviceWidget::class,
                Widgets\MostVisitedPagesWidget::class,
                Widgets\TopReferrersListWidget::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

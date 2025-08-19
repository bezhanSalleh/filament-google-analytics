<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Pages;

use BezhanSalleh\FilamentGoogleAnalytics\Widgets;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class FilamentGoogleAnalyticsDashboard extends Page
{
    protected string $view = 'filament-google-analytics::pages.google-analytics-dashboard';

    public static function getNavigationIcon(): ?string
    {
        return (string) config('filament-google-analytics.dashboard_icon', 'heroicon-m-chart-bar');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-google-analytics::widgets.navigation_label');
    }

    public function getTitle(): string | Htmlable
    {
        return (string) __('filament-google-analytics::widgets.title');
    }

    public static function canView(): bool
    {
        return config('filament-google-analytics.dedicated_dashboard');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canView() && static::$shouldRegisterNavigation;
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget>>
     */
    protected function getHeaderWidgets(): array
    {
        return [
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
        ];
    }
}

<?php

namespace BezhanSalleh\GoogleAnalytics\Pages;

use BezhanSalleh\GoogleAnalytics\Widgets;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class GoogleAnalyticsDashboard extends Page
{
    protected string $view = 'google-analytics::pages.google-analytics-dashboard';

    public static function getNavigationIcon(): ?string
    {
        return (string) config('google-analytics.dashboard_icon', 'heroicon-m-chart-bar');
    }

    public static function getNavigationLabel(): string
    {
        return __('google-analytics::widgets.navigation_label');
    }

    public function getTitle(): string | Htmlable
    {
        return (string) __('google-analytics::widgets.title');
    }

    public static function canView(): bool
    {
        return config('google-analytics.dedicated_dashboard');
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
        ];
    }
}

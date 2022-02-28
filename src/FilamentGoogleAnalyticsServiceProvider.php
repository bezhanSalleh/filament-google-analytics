<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentGoogleAnalyticsServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        Pages\FilamentGoogleAnalyticsDashboard::class,
    ];

    protected array $widgets = [
        Widgets\PageViewsWidget::class,
        Widgets\VisitorsWidget::class,
        Widgets\ActiveUsersOneDayWidget::class,
        Widgets\ActiveUsersSevenDayWidget::class,
        Widgets\ActiveUsersFourteenDayWidget::class,
        Widgets\ActiveUsersTwentyEightDayWidget::class,
        Widgets\SessionsWidget::class,
        Widgets\SessionsDurationWidget::class,
        Widgets\SessionsByCountryWidget::class,
        Widgets\SessionsByDeviceWidget::class,
        Widgets\MostVisitedPagesWidget::class,
        Widgets\TopReferrersListWidget::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-google-analytics')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();
    }
}

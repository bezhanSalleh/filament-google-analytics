<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GoogleAnalyticsCard;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentGoogleAnalyticsServiceProvider extends PluginServiceProvider
{
    protected array $widgets = [
        Widgets\PageViewsAndVisitorsWidget::class,
        Widgets\ActiveUsersStatsOverviewWidget::class,
        Widgets\SessionsAndSessionsDurationWidget::class,
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
        // ->hasViewComponent('filament-google-analytics', GoogleAnalyticsCard::class);
    }
}

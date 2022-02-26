<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets;

class FilamentGoogleAnalyticsServiceProvider extends PluginServiceProvider
{
    protected array $widgets = [
        Widgets\PageViewsAndVisitorsWidget::class,
        Widgets\ActiveUsersStatsOverviewWidget::class,
        Widgets\SessionsAndSessionsDurationWidget::class,
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

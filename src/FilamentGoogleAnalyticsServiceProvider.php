<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentGoogleAnalyticsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-google-analytics')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        WidgetManager::make()->boot();

        FilamentAsset::register([
            Css::make('filament-google-analytics', __DIR__ . '/../resources/dist/filament-google-analytics.css'),
        ], 'bezhansalleh/filament-google-analytics');
    }
}

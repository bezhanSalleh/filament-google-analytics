<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Spatie\LaravelPackageTools\Package;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\AlpineComponent;
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
        FilamentAsset::register([
            AlpineComponent::make('fGAChart', __DIR__ . '/../resources/dist/fGAChart.js'),
        ], 'bezhansalleh/filament-google-analytics');
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use BezhanSalleh\FilamentGoogleAnalytics\Commands\FilamentGoogleAnalyticsCommand;

class FilamentGoogleAnalyticsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-google-analytics')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament-google-analytics_table')
            ->hasCommand(FilamentGoogleAnalyticsCommand::class);
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalyticsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BezhanSalleh\\FilamentGoogleAnalytics\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentGoogleAnalyticsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-google-analytics_table.php.stub';
        $migration->up();
        */
    }
}

<?php

namespace BezhanSalleh\GoogleAnalytics\Tests;

use BezhanSalleh\GoogleAnalytics\GoogleAnalyticsServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Factory::guessFactoryNamesUsing(
        //     fn (string $modelName) => 'BezhanSalleh\\GoogleAnalytics\\Database\\Factories\\'.class_basename($modelName).'Factory'
        // );
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            GoogleAnalyticsServiceProvider::class,
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

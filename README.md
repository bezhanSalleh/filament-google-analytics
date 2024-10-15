<a href="https://github.com/bezhansalleh/filament-google-analytics" class="filament-hidden">
<img style="width: 100%; max-width: 100%;" alt="filament-google-analytics-art" src="https://user-images.githubusercontent.com/10007504/156520889-0abeb87d-a231-4f63-a79a-774fbd92ee5c.png" >
</a>


<p align="center" class="flex justify-center items-center">
    <a href="https://filamentphp.com/docs/3.x/panels/installation">
        <img alt="FILAMENT 8.x" src="https://img.shields.io/badge/FILAMENT-3.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://packagist.org/packages/bezhansalleh/filament-google-analytics">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/bezhansalleh/filament-google-analytics.svg?style=for-the-badge&logo=packagist">
    </a>
<!--     <a href="https://github.com/bezhansalleh/filament-google-analytics/actions?query=workflow%3Arun-tests+branch%3Amain" class="filament-hidden">
        <img alt="Tests Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-google-analytics/run-tests.yml?style=for-the-badge&logo=github&label=tests">
    </a> -->
    <a href="https://github.com/bezhansalleh/filament-google-analytics/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain" class="filament-hidden">
        <img alt="Code Style Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-google-analytics/laravel-pint.yml?style=for-the-badge&logo=github&label=code%20style">
    </a>

<a href="https://packagist.org/packages/bezhansalleh/filament-google-analytics">
    <img alt="Downloads" src="https://img.shields.io/packagist/dt/bezhansalleh/filament-google-analytics.svg?style=for-the-badge" >
    </a>
<p>

# Filament Google Analytics (GA4)
Google Analytics integration for [Filament (FilamentAdmin)](https://filamentphp.com)

# Installation

You can install the package in to a Laravel app that uses [Filament](https://filamentphp.com) via composer:

```bash
composer require bezhansalleh/filament-google-analytics
```

For now, follow the directions on [Spatie's Laravel Google Analytics package](https://github.com/spatie/laravel-analytics) for getting your credentials, then put them here:

```
yourapp/storage/app/analytics/service-account-credentials.json
```

Also add this to the `.env` for your Filament PHP app:

```ini
ANALYTICS_PROPERTY_ID=
```


> [!NOTE]  
> The plugin is developed to work in any Livewire project that uses the standalone `filament/widgets` package. But it also comes with a dedicated dashboard, which is a normal filament page. You can enable it by registering the plugin for the panels you want to use it in. If you are not using filament panels then you can skip this step.
> 

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ...
            \BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalyticsPlugin::make()
        ]);
}
```

# Usage

All the widgets are enabled by default for you to use them in your filament pages/resources. In order to enable the widgets for the default filament dashboard, you need to set the `filament_dashboard` option to `true` in the config file `filament-google-analytics.php` for each widget you want to enable.

Publish the config files and set your settings:
```bash
php artisan vendor:publish --tag=filament-google-analytics-config
```

#### Available Widgets
```php
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\PageViewsWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\VisitorsWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersOneDayWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersSevenDayWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersTwentyEightDayWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsDurationWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsByCountryWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsByDeviceWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\MostVisitedPagesWidget::class,
\BezhanSalleh\FilamentGoogleAnalytics\Widgets\TopReferrersListWidget::class,
```

#### Custom Dashboard
Though this plugin comes with a default dashboard, but sometimes you might want to change `navigationLabel` or `navigationGroup` or disable some `widgets` or any other options and given that the dashboard is a simple filament `page`; The easiest solution would be to disable the default dashboard and create a new `page`:

```bash
php artisan filament:page MyCustomDashboardPage
```
then register the widgets you want from the **Available Widgets** list either in the `getHeaderWidgets()` or `getFooterWidgets()`:
```php
<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets;

class MyCustomDashboardPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-custom-dashboard-page';

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\PageViewsWidget::class,
            Widgets\VisitorsWidget::class,
            Widgets\ActiveUsersOneDayWidget::class,
            Widgets\ActiveUsersSevenDayWidget::class,
            Widgets\ActiveUsersTwentyEightDayWidget::class,
            Widgets\SessionsWidget::class,
            Widgets\SessionsDurationWidget::class,
            Widgets\SessionsByCountryWidget::class,
            Widgets\SessionsByDeviceWidget::class,
            Widgets\MostVisitedPagesWidget::class,
            Widgets\TopReferrersListWidget::class,
        ];
    }
}
```
> [!NOTE]  
> In order to enable the widgets for the default filament dashboard, you need to set the `filament_dashboard` option to `true` in the config file `filament-google-analytics.php` for each widget you want to enable.

# Demo
Widgets rendered in a dedicated dashboard (or any other page you create)
![Demo](https://raw.githubusercontent.com/bezhanSalleh/filament-google-analytics/master/bin/v2-art.png?raw=true "Simple Demo")

# Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

# Contributing
If you want to contribute to this packages, you may want to test it in a real Filament project:

- Fork this repository to your GitHub account.
- Create a Filament app locally.
- Clone your fork in your Filament app's root directory.
- In the `/filament-google-analytics` directory, create a branch for your fix, e.g. `fix/error-message`.

Install the packages in your app's `composer.json`:

```json
"require": {
    "bezhansalleh/filament-google-analytics": "dev-fix/error-message as main-dev",
},
"repositories": [
    {
        "type": "path",
        "url": "filament-google-analytics"
    }
]
```

Now, run `composer update`.


Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

# Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

# Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [Laravel Analytics](https://github.com/spatie/laravel-analytics) By [Spatie](https://github.com/spatie)
- [Nova Google Analytics](https://github.com/tighten/nova-google-analytics) By [Tighten](https://github.com/tighten)
- [All Contributors](../../contributors)

# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

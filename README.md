# Filament Analytics
Google Analytics integration for Filament

(WIP)
- Configuration(abilitiy to enable or disable)
- Translations
- Improve the design

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-google-analytics.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-google-analytics)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bezhansalleh/filament-google-analytics/run-tests?label=tests)](https://github.com/bezhansalleh/filament-google-analytics/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bezhansalleh/filament-google-analytics/Check%20&%20fix%20styling?label=code%20style)](https://github.com/bezhansalleh/filament-google-analytics/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-google-analytics.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-google-analytics)


## Installation

You can install the package in to a Laravel app that uses [Filament](https://filamentphp.com) via composer:

```bash
composer require bezhansalleh/filament-google-analytics
```

For now, follow the directions on [Spatie's Laravel Google Analytics package](https://github.com/spatie/laravel-analytics) for getting your credentials, then put them here:

```
yourapp/storage/app/analytics/service-account-credentials.json
```

Also add this to the `.env` for your Nova app:

```ini
ANALYTICS_VIEW_ID=
```
## Usage

You must enable the widgets you want to display with Filament. By uncommenting them in the config file.

## Features
#### View the Visitors and Pageview Metrics
<img width="756" alt="Screen Shot 2022-02-26 at 12 35 41 PM" src="https://user-images.githubusercontent.com/10007504/155835519-d1fbb973-110d-4341-af50-8f5abea5f2f4.png">

#### View the Active Users Metrics
<img width="773" alt="Screen Shot 2022-02-26 at 12 48 57 PM" src="https://user-images.githubusercontent.com/10007504/155835949-beb4de3f-4d93-4f92-88fa-dd1678b907c8.png">


#### View the Sessions and Avg. Session Duration Metrics
<img width="756" alt="Screen Shot 2022-02-26 at 12 37 42 PM" src="https://user-images.githubusercontent.com/10007504/155835567-d88b644e-8f73-4c9d-b513-2abf2e704a16.png">

#### View the Devices and Country Metrics by Session (WIP)
<img width="850" alt="Screen Shot 2022-02-26 at 12 44 00 PM" src="https://user-images.githubusercontent.com/10007504/155835896-e20c4f8b-1cb1-4c5c-bb41-344025fbbf7a.png">

#### View the lists of Most Visited Pages and Referrers
<img width="902" alt="Screen Shot 2022-02-26 at 12 44 34 PM" src="https://user-images.githubusercontent.com/10007504/155835898-debb3935-81d4-4963-9b02-9734230be387.png">

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [Laravel Analytics](https://github.com/spatie/laravel-analytics) By [Spatie](https://github.com/spatie)
- [Nova Google Analytics](https://github.com/tighten/nova-google-analytics) By [Tighten](https://github.com/tighten)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

# Google Analytics integration with Filamentphp (FilamentAdmin)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-google-analytics.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-google-analytics)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bezhansalleh/filament-google-analytics/run-tests?label=tests)](https://github.com/bezhansalleh/filament-google-analytics/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bezhansalleh/filament-google-analytics/Check%20&%20fix%20styling?label=code%20style)](https://github.com/bezhansalleh/filament-google-analytics/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-google-analytics.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-google-analytics)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/filament-google-analytics.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/filament-google-analytics)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

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

You must enable the widgets you want to display with Filament. By uncommenting the widgets you want in the config file.

## Features
#### View the Visitors and Pageview Metrics

#### View the Active Users Metrics

#### View the Sessions and Avg. Session Duration Metrics

#### View the Devices and Country Metrics by Session (WIP)

#### View the lists of Most Visited Pages and Referrers

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

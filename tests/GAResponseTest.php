<?php

declare(strict_types=1);

use BezhanSalleh\GoogleAnalytics\Support\GAResponse;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

it('keeps absolute http and https urls', function (string $url): void {
    expect(GAResponse::sanitizeUrl($url))->toBe($url);
})->with([
    'https' => 'https://example.com/path?query=1',
    'http' => 'http://example.com',
]);

it('drops urls with other schemes or no scheme', function (?string $url): void {
    expect(GAResponse::sanitizeUrl($url))->toBeNull();
})->with([
    'javascript' => 'javascript:alert(1)',
    'data' => 'data:text/html,hi',
    'relative' => 'example.com/path',
    'empty' => '',
    'null' => null,
]);

it('falls back to the default period for an unknown filter', function (): void {
    $this->freezeTime();

    $default = Period::days(1);

    $analytics = Mockery::mock(Spatie\Analytics\Analytics::class);
    $analytics->shouldReceive('get')
        ->once()
        ->withArgs(fn (Period $period): bool => $period->startDate->equalTo($default->startDate)
            && $period->endDate->equalTo($default->endDate))
        ->andReturn(collect());

    Analytics::swap($analytics);

    expect(GAResponse::topReferrers('not-a-filter'))->toBe([]);
});

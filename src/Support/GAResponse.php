<?php

declare(strict_types=1);

namespace BezhanSalleh\GoogleAnalytics\Support;

use BezhanSalleh\GoogleAnalytics\GoogleAnalytics;
use Facades\BezhanSalleh\GoogleAnalytics\Support\GADataLookups;
use Illuminate\Support\Arr;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

final class GAResponse
{
    /**
     * Active Users data for stats widgets
     *
     * @param  array<int, array<string, mixed>>  $dataLookup
     * @return array{results: array<int>}
     */
    public static function activeUsers(array $dataLookup, ?string $filter = null): array
    {
        $filter ??= 'T';

        return Arr::get(
            $dataLookup,
            $filter,
            [
                'results' => [0],
            ],
        );
    }

    /**
     * Common method to handle the response data for:
     *  - Page Views
     *  - Visitors
     *  - Sessions
     *  - Sessions Duration
     *
     * @param  array<string, array<string, int>>  $dataLookup
     */
    public static function common(array $dataLookup, ?string $filter = null): GoogleAnalytics
    {
        $filter ??= 'T';

        $data = Arr::get(
            $dataLookup,
            $filter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        $result = is_numeric($data['result'] ?? null) ? (float) $data['result'] : 0;

        return GoogleAnalytics::for($result)
            ->previous((int) $data['previous'])
            ->format('%');
    }

    /**
     * Sessions by country data for pie chart widgets
     *
     * @return array<string, int|string>
     */
    public static function sessionsByCountry(?string $filter = null): array
    {
        $filter ??= 'T';

        $period = self::periodFor(GADataLookups::sessionsByDeviceAndByCountry(), $filter);

        $analyticsData = Analytics::get(
            $period,
            ['sessions'],
            ['country'],
            10,
            [OrderBy::metric('sessions', true)],
        );

        $results = [];
        foreach ($analyticsData as $analyticData) {
            $results[str($analyticData['country'])->studly()->append(' (' . number_format((int) $analyticData['sessions']) . ')')->toString()] = $analyticData['sessions'];
        }

        $total = 0;
        foreach ($results as $result) {
            $total += $result;
        }

        $results['total (' . number_format($total) . ')'] = number_format($total);

        return $results;
    }

    /**
     * @return array<string, int|string>
     */
    public static function sessionsByDevice(?string $filter = null): array
    {
        $filter ??= 'T';

        $period = self::periodFor(GADataLookups::sessionsByDeviceAndByCountry(), $filter);

        $analyticsData = Analytics::get(
            $period,
            ['sessions'],
            ['deviceCategory']
        );

        $results = [];

        foreach ($analyticsData as $analyticData) {
            $results[str($analyticData['deviceCategory'])->studly()->append(' (' . number_format((int) $analyticData['sessions']) . ')')->toString()] = $analyticData['sessions'];
        }

        $total = 0;
        foreach ($results as $result) {
            $total += $result;
        }

        $results['total (' . number_format($total) . ')'] = number_format($total);

        return $results;
    }

    /**
     * @return array<int, array{name: string, hostname: string, path: string, visits: int}>
     */
    public static function mostVisitedPages(?string $filter = null): array
    {
        $filter ??= 'T';

        $period = self::periodFor(GADataLookups::mostVisitedAndTopReferrers(), $filter);

        $analyticsData = Analytics::get(
            $period,
            ['screenPageViews'],
            ['pageTitle', 'hostName', 'pagePath'],
            10,
            [OrderBy::metric('screenPageViews', true)],
        );

        return array_map(
            fn (array $row): array => [
                'name' => (string) $row['pageTitle'],
                'hostname' => (string) $row['hostName'],
                'path' => (string) $row['pagePath'],
                'visits' => (int) $row['screenPageViews'],
            ],
            $analyticsData->toArray()
        );
    }

    /**
     * Top referrers data for table widgets
     *
     * @return array<int, array{url: string, pageViews: int}>
     */
    public static function topReferrers(?string $filter = null): array
    {
        $filter ??= 'T';

        $period = self::periodFor(GADataLookups::mostVisitedAndTopReferrers(), $filter);

        $analyticsData = Analytics::get(
            $period,
            ['activeUsers'],
            ['pageReferrer'],
            10,
            [OrderBy::dimension('activeUsers', true)],
        );

        return $analyticsData->map(fn (array $pageRow): array => [
            'url' => (string) $pageRow['pageReferrer'],
            'pageViews' => (int) $pageRow['activeUsers'],
        ])->all();
    }

    /**
     * Return the URL only when it is an absolute http(s) URL, so values that
     * reach the property through the Measurement Protocol cannot become
     * links with other schemes in the panel.
     */
    public static function sanitizeUrl(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true) ? $url : null;
    }

    /**
     * Resolve the period for a filter key, falling back to the default when the
     * key is not one of the known options.
     *
     * @param  array<string, Period>  $periods
     */
    private static function periodFor(array $periods, string $filter): Period
    {
        return $periods[$filter] ?? $periods['T'];
    }
}

<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics\Support;

use Illuminate\Support\Arr;
use Spatie\Analytics\OrderBy;
use Facades\App\Services\GADataLookups;
use Spatie\Analytics\Facades\Analytics;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;

final class GAResponse
{
    /**
     * Active Users data for stats widgets
     * @return array{results: array<int>}
     */
    public static function activeUsers(array $dataLookup, ?string $filter = null): array
    {
        $filter = $filter ?? 'T';

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
     * @param array<string, array<string, int>> $dataLookup
     */
    public static function common(array $dataLookup, ?string $filter = null): FilamentGoogleAnalytics
    {
        $filter = $filter ?? 'T';

        $data = Arr::get(
            $dataLookup,
            $filter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return FilamentGoogleAnalytics::for((int)$data['result'])
            ->previous((int)$data['previous'])
            ->format('%');
    }

    /**
     * Sessions by country data for pie chart widgets
     * @return array<string, int|string>
     */
    public static function sessionsByCountry(?string $filter = null): array
    {
        $filter = $filter ?? 'T';

        /** @var \Spatie\Analytics\Period $period */
        $period = GADataLookups::sessionsByDeviceAndByCountry()[$filter];

        $analyticsData = Analytics::get(
            $period,
            ['sessions'],
            ['country'],
            10,
            [OrderBy::metric('sessions', true)],
        );

        $results = [];
        foreach ($analyticsData as $row) {
            $results[str($row['country'])->studly()->append(' (' . number_format((int)$row['sessions']) . ')')->toString()] = $row['sessions'];
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
        $filter = $filter ?? 'T';

        /** @var \Spatie\Analytics\Period $period */
        $period = GADataLookups::sessionsByDeviceAndByCountry()[$filter];

        $analyticsData = Analytics::get(
            $period,
            ['sessions'],
            ['deviceCategory']
        );

        $results = [];

        foreach ($analyticsData as $row) {
            $results[str($row['deviceCategory'])->studly()->append(' (' . number_format((int)$row['sessions']) . ')')->toString()] = $row['sessions'];
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
        $filter = $filter ?? 'T';

        /** @var \Spatie\Analytics\Period $period */
        $period = GADataLookups::mostVisitedAndTopReferrers()[$filter];

        $analyticsData = Analytics::get(
            $period,
            ['screenPageViews'],
            ['pageTitle', 'hostName', 'pagePath'],
            10,
            [OrderBy::metric('screenPageViews', true)],
        );

        return array_map(
            function ($row) {
                return [
                    'name' => (string) $row['pageTitle'],
                    'hostname' => (string) $row['hostName'],
                    'path' => (string) $row['pagePath'],
                    'visits' => (int) $row['screenPageViews'],
                ];
            },
            $analyticsData->toArray()
        );
    }

    /**
     * Top referrers data for table widgets
     * @return array<int, array{url: string, pageViews: int}>
     */
    public static function topReferrers(?string $filter = null): array
    {
        $filter = $filter ?? 'T';

        /** @var \Spatie\Analytics\Period $period */
        $period = GADataLookups::mostVisitedAndTopReferrers()[$filter];

        $analyticsData = Analytics::get(
            $period,
            ['activeUsers'],
            ['pageReferrer'],
            10,
            [OrderBy::dimension('activeUsers', true)],
        );

        return $analyticsData->map(function (array $pageRow) {
            return [
                'url' => $pageRow['pageReferrer'],
                'pageViews' => (int) $pageRow['activeUsers'],
            ];
        })->all();
    }
}

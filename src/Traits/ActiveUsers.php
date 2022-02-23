<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

trait ActiveUsers
{
    private function performActiveUsersQuery(string $metric, int $days): array
    {
        $analyticsData = app(Analytics::class)
            ->performQuery(
                Period::days($days),
                $metric,
                [
                    'metrics' => $metric,
                    'dimensions' => 'ga:date',
                ]
            );

        $results = collect($analyticsData->getRows())->mapWithKeys(function ($row) {
            return [
                (new Carbon($row[0]))->format('M j') => intval($row[1]),
            ];
        });

        return ['results' => $results->toArray()];
    }
}

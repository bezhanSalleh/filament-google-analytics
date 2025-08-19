<?php

namespace BezhanSalleh\GoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

trait ActiveUsers
{
    /**
     * @return array{results: array<string, int>}
     */
    private function performActiveUsersQuery(string $metric, int $days): array
    {
        $analyticsData = Analytics::get(
            Period::days($days),
            [$metric],
            ['date']
        );

        $results = $analyticsData->mapWithKeys(fn (array $row) => [
            (new Carbon($row['date']))->format('M j') => $row[$metric],
        ])->sortKeys();

        return ['results' => $results->toArray()];
    }
}

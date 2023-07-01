<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

trait ActiveUsers
{
    private function performActiveUsersQuery(string $metric, int $days): array
    {
        $analyticsData = Analytics::get(
                Period::days($days),
                [$metric],
                ['date']
        );

        $results = $analyticsData->mapWithKeys(function ($row) use($metric){
            return [
                //(new Carbon($row['date']))->format('M j') => intval($row[1]),
                (new Carbon($row['date']))->format('M j') => $row[$metric],
            ];
        });

        return ['results' => $results->toArray()];
    }
}

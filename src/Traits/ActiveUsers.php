<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;

trait ActiveUsers
{
    use GAFetch;

    private function performActiveUsersQuery(string $metric, int $days): array
    {
        $analyticsData = $this->fetch(
            $days,
            [$metric],
            isset($this->pagePath) && !is_null($this->pagePath) ? ['pagePath', 'date'] : ['date'],
            $this->pagePath ?? null,
        );

        $results = $analyticsData->mapWithKeys(function ($row) use ($metric) {
            return [
                //(new Carbon($row['date']))->format('M j') => intval($row[1]),
                (new Carbon($row['date']))->format('M j') => $row[$metric],
            ];
        });

        return ['results' => $results->toArray()];
    }
}

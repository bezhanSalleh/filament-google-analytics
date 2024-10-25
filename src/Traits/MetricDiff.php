<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait MetricDiff
{
    private function get(string $metric, string $dimensions, Period $period): Collection
    {
        $analyticsData = Analytics::get(
            $period,
            [$metric],
            [$dimensions],
            orderBy: [
                OrderBy::dimension($dimensions, true),
            ],
        );

        $results = $analyticsData;

        return collect($results ?? [])->map(function (array $dateRow) use ($metric, $dimensions) {
            return [
                'date' => $dateRow[$dimensions],
                'value' => $dateRow[$metric],
            ];
        });
    }

    private function getLastWeek(): array
    {
        $current = Period::create(
            Carbon::today()
                ->clone()
                ->startOfWeek(Carbon::SUNDAY)
                ->subWeek(),
            Carbon::today()
                ->clone()
                ->subWeek()
                ->endOfWeek(Carbon::SATURDAY)
        );

        $previous = Period::create(
            Carbon::today()
                ->clone()
                ->startOfWeek(Carbon::SUNDAY)
                ->subWeeks(2),
            Carbon::today()
                ->clone()
                ->subWeeks(2)
                ->endOfWeek(Carbon::SATURDAY)
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }

    private function getLastMonth(): array
    {
        $current = Period::create(
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonth(),
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonth()
                ->endOfMonth()
        );

        $previous = Period::create(
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonths(2),
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonths(2)
                ->endOfMonth()
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }

    private function getLastSevenDays(): array
    {
        $current = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(6),
            Carbon::yesterday()
        );

        $previous = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(13),
            Carbon::yesterday()
                ->clone()
                ->subDays(7)
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }

    private function getLastThirtyDays(): array
    {
        $current = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(29),
            Carbon::yesterday()
        );

        $previous = Period::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(59),
            Carbon::yesterday()
                ->clone()
                ->subDays(30)
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }
}

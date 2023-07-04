<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\InListFilter;
use Google\Analytics\Data\V1beta\FilterExpression;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

trait GAFetch
{
    private function fetch(int|Period $days, array $metrics, array|null $dimensions = ['date'], array|null $paths = null): \Illuminate\Support\Collection|array
    {
        return Analytics::get(
            period: $days instanceof Period ? $days : Period::days($days),
            metrics: $metrics,
            dimensions: $dimensions,
            dimensionFilter: collect($dimensions)->contains('pagePath')
                ? new FilterExpression([
                    'filter' => new Filter([
                        'field_name' => 'pagePath',
                        'in_list_filter' => new InListFilter([
                            'values' => $paths ?? [],
                        ]),
                    ]),
                ])
                : null,
        );
    }
}

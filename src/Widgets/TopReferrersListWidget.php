<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class TopReferrersListWidget extends ChartWidget
{
    use Traits\CanViewWidget;

    protected static ?string $pollingInterval = null;

    protected static string $view = 'filament-google-analytics::widgets.top-referrers-list';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public function getHeading(): string | Htmlable | null
    {
        return __('filament-google-analytics::widgets.top_referrers');
    }

    protected function getFilters(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'TW' => __('filament-google-analytics::widgets.TW'),
            'TM' => __('filament-google-analytics::widgets.TM'),
            'TY' => __('filament-google-analytics::widgets.TY'),
        ];
    }

    protected function getData(): array
    {
        $lookups = [
            'T' => Period::days(1),
            'TW' => Period::days(7),
            'TM' => Period::months(1),
            'TY' => Period::years(1),
        ];

        $analyticsData = Analytics::get(
            $lookups[$this->filter],
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

    protected function getType(): string
    {
        return 'line';
    }
}

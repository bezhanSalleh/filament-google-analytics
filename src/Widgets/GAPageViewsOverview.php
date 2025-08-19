<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Support\GAFilters;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAResponse;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAStatsBuilder;
use Facades\BezhanSalleh\FilamentGoogleAnalytics\Support\GADataLookups;
use Filament\Widgets\StatsOverviewWidget;

class GAPageViewsOverview extends StatsOverviewWidget
{
    public ?string $filter = 'T';

    protected ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 1;

    /**
     * @var int | array<string, ?int> | null
     */
    protected int | array | null $columns = 1;

    protected function getStats(): array
    {
        return [
            GAStatsBuilder::make(__('filament-google-analytics::widgets.page_views'))
                ->usingResponse(GAResponse::common(GADataLookups::pageViews(), $this->filter))
                ->withSelectFilter(GAFilters::common(), $this->filter)
                ->resolve(),
        ];
    }
}

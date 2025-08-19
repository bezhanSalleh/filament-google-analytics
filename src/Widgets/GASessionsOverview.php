<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Support\GAFilters;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAResponse;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAStatsBuilder;
use Facades\BezhanSalleh\FilamentGoogleAnalytics\Support\GADataLookups;
use Filament\Widgets\StatsOverviewWidget;

class GASessionsOverview extends StatsOverviewWidget
{
    public ?string $filter = 'T';

    protected ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 3;

    /**
     * @var int | array<string, ?int> | null
     */
    protected int | array | null $columns = 1;

    protected function getStats(): array
    {
        return [
            GAStatsBuilder::make(__('filament-google-analytics::widgets.sessions'))
                ->usingResponse(GAResponse::common(GADataLookups::sessions(), $this->filter))
                ->withSelectFilter(GAFilters::common(), $this->filter)
                ->resolve(),
        ];
    }
}

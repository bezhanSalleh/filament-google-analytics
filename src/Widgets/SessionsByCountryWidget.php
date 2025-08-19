<?php

namespace BezhanSalleh\GoogleAnalytics\Widgets;

use BezhanSalleh\GoogleAnalytics\Support\GAFilters;
use BezhanSalleh\GoogleAnalytics\Support\GAResponse;
use BezhanSalleh\GoogleAnalytics\Support\GAStatsBuilder;
use BezhanSalleh\GoogleAnalytics\Traits\CanViewWidget;
use Facades\BezhanSalleh\GoogleAnalytics\Support\GADataLookups;
use Filament\Widgets\StatsOverviewWidget;

class SessionsByCountryWidget extends StatsOverviewWidget
{
    use CanViewWidget;

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
            GAStatsBuilder::make(__('google-analytics::widgets.sessions_duration'), 'time')
                ->usingResponse(GAResponse::common(GADataLookups::sessionsDuration(), $this->filter))
                ->withSelectFilter(GAFilters::common(), $this->filter)
                ->resolve(),
        ];
    }
}

<?php

namespace BezhanSalleh\GoogleAnalytics\Widgets;

use BezhanSalleh\GoogleAnalytics\Support\GAFilters;
use BezhanSalleh\GoogleAnalytics\Support\GAResponse;
use BezhanSalleh\GoogleAnalytics\Support\GAStatsBuilder;
use BezhanSalleh\GoogleAnalytics\Traits\CanViewWidget;
use Facades\BezhanSalleh\GoogleAnalytics\Support\GADataLookups;
use Filament\Widgets\StatsOverviewWidget;

class ActiveUsersTwentyEightDayWidget extends StatsOverviewWidget
{
    use CanViewWidget;

    public ?string $filter = '5';

    protected ?string $pollingInterval = null;

    // protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 2;

    /**
     * @var int | array<string, ?int> | null
     */
    protected int | array | null $columns = 1;

    protected function getStats(): array
    {
        return [
            GAStatsBuilder::make(__('google-analytics::widgets.twenty_eight_day_active_users'))
                ->usingResponse(GAResponse::activeUsers(GADataLookups::activeUsers('active28DayUsers'), $this->filter))
                ->withSelectFilter(GAFilters::activeUsers(), $this->filter)
                ->resolve(),
        ];
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Support\GAFilters;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAResponse;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAStatsBuilder;
use BezhanSalleh\FilamentGoogleAnalytics\Traits\CanViewWidget;
use Facades\BezhanSalleh\FilamentGoogleAnalytics\Support\GADataLookups;
use Filament\Widgets\StatsOverviewWidget;

class GAActiveUsersSevenDayOverview extends StatsOverviewWidget
{
    use CanViewWidget;

    public ?string $filter = '5';

    protected ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 2;

    /**
     * @var int | array<string, ?int> | null
     */
    protected int | array | null $columns = 1;

    protected function getStats(): array
    {
        return [
            GAStatsBuilder::make(__('filament-google-analytics::widgets.seven_day_active_users'))
                ->usingResponse(GAResponse::activeUsers(GADataLookups::activeUsers('active7DayUsers'), $this->filter))
                ->withSelectFilter(GAFilters::activeUsers(), $this->filter)
                ->resolve(),
        ];
    }
}

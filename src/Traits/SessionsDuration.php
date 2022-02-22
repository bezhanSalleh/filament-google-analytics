<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use App\FormatNumber;
use Illuminate\Support\Arr;
use Spatie\Analytics\Period;
use Filament\Widgets\StatsOverviewWidget\Card;
use BezhanSalleh\FilamentGoogleAnalytics\AnalyticsResult;

trait SessionsDuration
{
    use MetricDiff;

    public ?string $defaultSessionsDurationFilter = '1';

    private function sessionDurationToday(): array
    {
        $results = $this->performQuery('ga:avgSessionDuration', 'ga:date', Period::days(1));

        return [
            'previous' => $results->first()['value'] ?? 0,
            'result' => $results->last()['value'] ?? 0,
        ];
    }

    private function sessionDurationYesterday(): array
    {
        $results = $this->performQuery('ga:avgSessionDuration', 'ga:date', Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'previous' => $results->first()['value'] ?? 0,
            'result' => $results->last()['value'] ?? 0,
        ];
    }

    private function sessionDurationLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionDurationLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:avgSessionDuration', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }


    public function SessionsDurationFilters(): array
    {
        return [
            1 => __('Today'),
            'Y' => __('Yesterday'),
            'LW' => __('Last Week'),
            'LM' => __('Last Month'),
            7 => __('Last 7 Days'),
            30 => __('Last 30 Days'),
        ];
    }

    public function sessionsDuration($value)
    {
        $lookups = [
            1 => $this->sessionDurationToday(),
            'Y' => $this->sessionDurationYesterday(),
            'LW' =>$this->sessionDurationLastWeek(),
            'LM' => $this->sessionDurationLastMonth(),
            7 => $this->sessionDurationLastSevenDays(),
            30 => $this->sessionDurationLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $value,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        $this->defaultSessionsDurationFilter = $value;

        return (new AnalyticsResult($data['result']))
            ->previous($data['previous'])
            ->format('%');
    }

    protected function calculateSessionsDurationStats($value, $previous)
    {
        if ($previous == 0 || $previous == null || $value == 0) {
            return 0;
        }

        return (int) ((($value - $previous) / $previous) * 100);
    }

    public function formatSessionsDurationDescription($value, $label, $format): string
    {
        return FormatNumber::format($value) . ''.$format .' '. $label;
    }

    public function getSessionsDurationCardStats()
    {
       $result = $this->sessionsDuration($this->defaultSessionsDurationFilter);
       $value = $result->value;
       $previous = $result->previous;
       $format = $result->format;
       $label = gmp_sign($this->calculateSessionsDurationStats($value, $previous)) > 0 ? 'Increase' : 'Decrease';
       $color = gmp_sign($this->calculateSessionsDurationStats($value, $previous)) > 0 ? 'success' : 'danger';
       $icon = gmp_sign($this->calculateSessionsDurationStats($value, $previous)) > 0 ? 'heroicon-o-trending-up' : 'heroicon-o-trending-up';
       $description = $this->formatSessionsDurationDescription($value, $label, $format);

       return [
           'value' => FormatNumber::format($value),
           'description' => $description,
           'color' => $color,
           'icon' => $icon,
       ];
    }
    public function sessionsDurationCard(): Card
    {
        return Card::make('Sessions Duration', $this->getSessionsDurationCardStats()['value'])
            ->description($this->getSessionsDurationCardStats()['description'])
            ->descriptionColor($this->getSessionsDurationCardStats()['color'])
            ->descriptionIcon($this->getSessionsDurationCardStats()['icon'])
            ->filters($this->sessionsDurationFilters())
            ->action('sessionsDuration');
    }
}

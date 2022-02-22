<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use App\FormatNumber;
use Illuminate\Support\Arr;
use Spatie\Analytics\Period;
use Filament\Widgets\StatsOverviewWidget\Card;
use BezhanSalleh\FilamentGoogleAnalytics\AnalyticsResult;

trait Sessions
{
    use MetricDiff;

    public ?string $defaultSessionsFilter = '1';

    private function sessionsToday(): array
    {
        $results = $this->performQuery('ga:sessions', 'ga:date', Period::days(1));

        return [
            'previous' => $results->first()['value'] ?? 0,
            'result' => $results->last()['value'] ?? 0,
        ];
    }

    private function sessionsYesterday(): array
    {
        $results = $this->performQuery('ga:sessions', 'ga:date', Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'previous' => $results->first()['value'] ?? 0,
            'result' => $results->last()['value'] ?? 0,
        ];
    }

    private function sessionsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:sessions', 'ga:year', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:sessions', 'ga:year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:sessions', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:sessions', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:sessions', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:sessions', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }

    private function sessionsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:sessions', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:sessions', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')[0] ?? 0,
            'result' => $currentResults->pluck('value')[0] ?? 0,
        ];
    }


    public function SessionsFilters(): array
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

    public function sessions($value)
    {
        $lookups = [
            1 => $this->sessionsToday(),
            'Y' => $this->sessionsYesterday(),
            'LW' =>$this->sessionsLastWeek(),
            'LM' => $this->sessionsLastMonth(),
            7 => $this->sessionsLastSevenDays(),
            30 => $this->sessionsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $value,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        $this->defaultSessionsFilter = $value;

        return (new AnalyticsResult($data['result']))
            ->previous($data['previous'])
            ->format('%');
    }

    protected function calculateSessionsStats($value, $previous)
    {
        if ($previous == 0 || $previous == null || $value == 0) {
            return 0;
        }

        return (int) ((($value - $previous) / $previous) * 100);
    }

    public function formatSessionsDescription($value, $label, $format): string
    {
        return FormatNumber::format($value) . ''.$format .' '. $label;
    }

    public function getSessionsCardStats()
    {
       $result = $this->sessions($this->defaultSessionsFilter);
       $value = $result->value;
       $previous = $result->previous;
       $format = $result->format;
       $label = gmp_sign($this->calculateSessionsStats($value, $previous)) > 0 ? 'Increase' : 'Decrease';
       $color = gmp_sign($this->calculateSessionsStats($value, $previous)) > 0 ? 'success' : 'danger';
       $icon = gmp_sign($this->calculateSessionsStats($value, $previous)) > 0 ? 'heroicon-o-trending-up' : 'heroicon-o-trending-up';
       $description = $this->formatSessionsDescription($value, $label, $format);

       return [
           'value' => FormatNumber::format($value),
           'description' => $description,
           'color' => $color,
           'icon' => $icon,
       ];
    }
    public function sessionsCard(): Card
    {
        return Card::make('Sessions', $this->getSessionsCardStats()['value'])
            ->description($this->getSessionsCardStats()['description'])
            ->descriptionColor($this->getSessionsCardStats()['color'])
            ->descriptionIcon($this->getSessionsCardStats()['icon'])
            ->filters($this->sessionsFilters())
            ->action('sessions');
    }
}

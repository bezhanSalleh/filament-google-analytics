<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use App\FormatNumber;
use Illuminate\Support\Arr;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;
use Filament\Widgets\StatsOverviewWidget\Card;
use BezhanSalleh\FilamentGoogleAnalytics\AnalyticsResult;

trait Visitors
{
    use MetricDiff;

    public ?string $defaultVisitorsFilter = '1';

    private function visitorsToday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => $analyticsData->last()['visitors'] ?? 0,
            'previous' => $analyticsData->first()['visitors'] ?? 0,
        ];
    }

    private function visitorsYesterday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => $analyticsData->last()['visitors'] ?? 0,
            'previous' => $analyticsData->first()['visitors'] ?? 0,
        ];
    }

    private function visitorsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:users', 'ga:date', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:date', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:users', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:users', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function visitorsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:users', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:users', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    public function visitorsFilters(): array
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

    public function visitors($value)
    {
        $lookups = [
            1 => $this->visitorsToday(),
            'Y' => $this->visitorsYesterday(),
            'LW' =>$this->visitorsLastWeek(),
            'LM' => $this->visitorsLastMonth(),
            7 => $this->visitorsLastSevenDays(),
            30 => $this->visitorsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $value,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        $this->defaultVisitorsFilter = $value;

        return (new AnalyticsResult($data['result']))
            ->previous($data['previous'])
            ->format('%');
    }

    protected function calculateVisitorStats($value, $previous)
    {
        if ($previous == 0 || $previous == null || $value == 0) {
            return 0;
        }

        return (int) ((($value - $previous) / $previous) * 100);
    }

    public function formatVisitorsDescription($value, $label, $format): string
    {
        return FormatNumber::format($value) . ''.$format .' '. $label;
    }

    public function getVisitorsCardStats()
    {
       $result = $this->visitors($this->defaultVisitorsFilter);
       $value = $result->value;
       $previous = $result->previous;
       $format = $result->format;
       $label = gmp_sign($this->calculateVisitorStats($value, $previous)) > 0 ? 'Increase' : 'Decrease';
       $color = gmp_sign($this->calculateVisitorStats($value, $previous)) > 0 ? 'success' : 'danger';
       $icon = gmp_sign($this->calculateVisitorStats($value, $previous)) > 0 ? 'heroicon-o-trending-up' : 'heroicon-o-trending-up';
       $description = $this->formatVisitorsDescription($value, $label, $format);

       return [
           'value' => FormatNumber::format($value),
           'description' => $description,
           'color' => $color,
           'icon' => $icon,
       ];
    }
    public function visitorsCard(): Card
    {
        return Card::make('Visitors', $this->getVisitorsCardStats()['value'])
            ->description($this->getVisitorsCardStats()['description'])
            ->descriptionColor($this->getVisitorsCardStats()['color'])
            ->descriptionIcon($this->getVisitorsCardStats()['icon'])
            ->filters($this->visitorsFilters())
            ->action('visitors');
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use Carbon\Carbon;
use App\FormatNumber;
use Illuminate\Support\Arr;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;
use Filament\Widgets\StatsOverviewWidget\Card;
use BezhanSalleh\FilamentGoogleAnalytics\AnalyticsResult;

trait PageViews
{
    use MetricDiff;

    public ?string $defaultPageViewFilter = '1';

    private function pageViewsToday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::days(1));

        return [
            'result' => $analyticsData->last()['pageViews'] ?? 0,
            'previous' => $analyticsData->first()['pageViews'] ?? 0,
        ];
    }

    private function pageViewsYesterday(): array
    {
        $analyticsData = app(Analytics::class)
            ->fetchTotalVisitorsAndPageViews(Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()));

        return [
            'result' => $analyticsData->last()['pageViews'] ?? 0,
            'previous' => $analyticsData->first()['pageViews'] ?? 0,
        ];
    }

    private function pageViewsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastWeek['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastWeek['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastMonth['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastMonth['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastSevenDays['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastSevenDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    private function pageViewsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();
        $currentResults = $this->performQuery('ga:pageviews', 'ga:year', $lastThirtyDays['current']);
        $previousResults = $this->performQuery('ga:pageviews', 'ga:year', $lastThirtyDays['previous']);

        return [
            'previous' => $previousResults->pluck('value')->sum() ?? 0,
            'result' => $currentResults->pluck('value')->sum() ?? 0,
        ];
    }

    public function pageViewsFilters(): array
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

    public function pageViews($value)
    {
        $lookups = [
            1 => $this->pageViewsToday(),
            'Y' => $this->pageViewsYesterday(),
            'LW' =>$this->pageViewsLastWeek(),
            'LM' => $this->pageViewsLastMonth(),
            7 => $this->pageViewsLastSevenDays(),
            30 => $this->pageViewsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $value,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        $this->defaultPageViewFilter = $value;

        return (new AnalyticsResult($data['result']))
            ->previous($data['previous'])
            ->format('%');
    }

    protected function calculateStats($value, $previous)
    {
        if ($previous == 0 || $previous == null || $value == 0) {
            return 0;
        }

        return (int) ((($value - $previous) / $previous) * 100);
    }

    public function formatDescription($value, $label, $format): string
    {
        return FormatNumber::format($value) . $format .' '. $label;
    }

    public function getCardStats()
    {
       $result = $this->pageViews($this->defaultPageViewFilter);
       $value = $result->value;
       $previous = $result->previous;
       $format = $result->format;
       $label = gmp_sign($this->calculateStats($value, $previous)) > 0 ? 'Increase' : 'Decrease';
       $color = gmp_sign($this->calculateStats($value, $previous)) > 0 ? 'success' : 'danger';
       $icon = gmp_sign($this->calculateStats($value, $previous)) > 0 ? 'heroicon-o-trending-up' : 'heroicon-o-trending-up';
       $description = $this->formatDescription($value, $label, $format);

       return [
           'value' => FormatNumber::format($value),
           'description' => $description,
           'color' => $color,
           'icon' => $icon,
       ];
    }
    public function pageViewsCard(): Card
    {
        return Card::make('Page Views', $this->getCardStats()['value'])
            ->description($this->getCardStats()['description'])
            ->descriptionColor($this->getCardStats()['color'])
            ->descriptionIcon($this->getCardStats()['icon'])
            ->filters($this->pageViewsFilters())
            ->action('pageViews');
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Arr;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\GoogleAnalyticsCard;

class PageViewsAndVisitorsWidget extends BaseWidget
{
    use Traits\Visitors;
    use Traits\PageViews;

    // protected int | string | array $columnSpan = 1;

    public ?array $filters = [
        'page-views' => 'T',
        'visitors' => 'T'
    ];

    protected function getCards(): array
    {
        return [
            GoogleAnalyticsCard::make('Unique Users', $this->getContent()['value'])
                ->id('visitors')
                ->color($this->getContent()['color'])
                ->description($this->getContent()['description'])
                ->descriptionIcon($this->getContent()['icon'])
                ->filters($this->filters()),
            GoogleAnalyticsCard::make('Page Views', $this->getPageViewContent()['value'])
                ->id('page-views')
                ->color($this->getPageViewContent()['color'])
                ->description($this->getPageViewContent()['description'])
                ->descriptionIcon($this->getPageViewContent()['icon'])
                ->filters($this->filters())
        ];
    }

    public function updatedFilters($value,$key)
    {
        if ($key === 'visitors') {
            $this->filters['visitors'] = $value;
            $this->initializeContent();
        }

        if ($key === 'page-views') {
            $this->filters['page-views'] = $value;
            $this->initializePageViewContent();
        }
    }

    public function initializeContent()
    {
        $lookups = [
            'T' =>  $this->visitorsToday(),
            'Y' =>  $this->visitorsYesterday(),
            'LW'    =>  $this->visitorsLastWeek(),
            'LM'    =>  $this->visitorsLastMonth(),
            'LSD'   =>  $this->visitorsLastSevenDays(),
            'LTD'   =>  $this->visitorsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['visitors'],
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return FilamentGoogleAnalytics::for($data['result'])
            ->previous($data['previous'])
            ->format('%');
    }

    /**
     * Get Card contents
     *
     * @return array
     */
    public function getContent(): array
    {
        return [
            'value' => $this->initializeContent()->trajectoryValue(),
            'icon' => $this->initializeContent()->trajectoryIcon(),
            'color' => $this->initializeContent()->trajectoryColor(),
            'description' => $this->initializeContent()->trajectoryDescription(),
        ];
    }

    public function initializePageViewContent()
    {
        $lookups = [
            'T' =>  $this->pageViewsToday(),
            'Y' =>  $this->pageViewsYesterday(),
            'LW'    =>  $this->pageViewsLastWeek(),
            'LM'    =>  $this->pageViewsLastMonth(),
            'LSD'   =>  $this->pageViewsLastSevenDays(),
            'LTD'   =>  $this->pageViewsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['page-views'],
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return FilamentGoogleAnalytics::for($data['result'])
            ->previous($data['previous'])
            ->format('%');

    }

    public function getPageViewContent(): array
    {
        return [
            'value' => $this->initializePageViewContent()->trajectoryValue(),
            'icon' => $this->initializePageViewContent()->trajectoryIcon(),
            'color' => $this->initializePageViewContent()->trajectoryColor(),
            'description' => $this->initializePageViewContent()->trajectoryDescription(),
        ];
    }

    public function filters(): array
    {
        return [
            'T' =>  'Today',
            'Y' =>  'Yesterday',
            'LW'    =>  'Last Week',
            'LM'    =>  'Last Month',
            'LSD'   =>  'Last 7 Days',
            'LTD'   =>  'Last 30 Days',
        ];
    }
}

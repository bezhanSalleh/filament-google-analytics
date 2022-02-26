<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Support\Arr;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;

class ActiveUsersStatsOverviewWidget extends BaseWidget
{
    use Traits\ActiveUsers;

    public ?array $filters = [
        'one-day-active-users' => '5',
        'seven-day-active-users' => '5',
        'fourteen-day-active-users' => '5',
        'twenty-eight-day-active-users' => '5',
    ];

    protected function getCards(): array
    {
        return [
            GoogleAnalyticsCard::make('1 Day Active Users', $this->getOneDayActiveUsersContent()['value'])
                ->id('one-day-active-users')
                ->filters($this->filters())
                ->chart($this->getOneDayActiveUsersContent()['chart'])
                ->color($this->getOneDayActiveUsersContent()['color']),
            GoogleAnalyticsCard::make('7 Day Active Users', $this->getSevenDayActiveUsersContent()['value'])
                ->id('seven-day-active-users')
                ->filters($this->filters())
                ->chart($this->getSevenDayActiveUsersContent()['chart'])
                ->color($this->getSevenDayActiveUsersContent()['color']),
            GoogleAnalyticsCard::make('14 Day Active Users', $this->getFourteenDayActiveUsersContent()['value'])
                ->id('fourteen-day-active-users')
                ->filters($this->filters())
                ->chart($this->getFourteenDayActiveUsersContent()['chart'])
                ->color($this->getFourteenDayActiveUsersContent()['color']),
            GoogleAnalyticsCard::make('28 Day Active Users', $this->getTwentyEightDayActiveUsersContent()['value'])
                ->id('twenty-eight-day-active-users')
                ->filters($this->filters())
                ->chart($this->getTwentyEightDayActiveUsersContent()['chart'])
                ->color($this->getTwentyEightDayActiveUsersContent()['color'])
        ];
    }

    public function updatedFilters($value,$key)
    {
        if ($key === 'one-day-active-users') {
            $this->filters['one-day-active-users'] = $value;
            $this->initializeOneDayActiveUsersContent();

            $this->dispatchBrowserEvent('updateStatsChartData',[
                'id' => $key,
                'data' => array_values($this->initializeOneDayActiveUsersContent()['results'])
            ]);
        }

        if ($key === 'seven-day-active-users') {
            $this->filters['seven-day-active-users'] = $value;
            $this->initializeSevenDayActiveUsersContent();

            $this->dispatchBrowserEvent('updateStatsChartData',[
                'id' => $key,
                'data' => array_values($this->initializeSevenDayActiveUsersContent()['results'])
            ]);
        }

        if ($key === 'fourteen-day-active-users') {
            $this->filters['fourteen-day-active-users'] = $value;
            $this->initializeFourteenDayActiveUsersContent();

            $this->dispatchBrowserEvent('updateStatsChartData',[
                'id' => $key,
                'data' => array_values($this->initializeFourteenDayActiveUsersContent()['results'])
            ]);
        }

        if ($key === 'fourteen-day-active-users') {
            $this->filters['twenty-eight-day-active-users'] = $value;
            $this->initializeTwentyEightDayActiveUsersContent();

            $this->dispatchBrowserEvent('updateStatsChartData',[
                'id' => $key,
                'data' => array_values($this->initializeTwentyEightDayActiveUsersContent()['results'])
            ]);
        }

    }

    public function initializeOneDayActiveUsersContent()
    {
        $lookups = [
            '5' => $this->performActiveUsersQuery('ga:1dayUsers', 5),
            '10' => $this->performActiveUsersQuery('ga:1dayUsers', 10),
            '15' => $this->performActiveUsersQuery('ga:1dayUsers', 15),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['one-day-active-users'],
            [
                'results' => [0],
            ],
        );

        return $data;
    }

    public function getOneDayActiveUsersContent(): array
    {
        return [
            'value' => FilamentGoogleAnalytics::for(last($this->initializeOneDayActiveUsersContent()['results']))->trajectoryValue(),
            'color' => 'primary',
            'chart' => array_values($this->initializeOneDayActiveUsersContent()['results'])
        ];
    }

    public function initializeSevenDayActiveUsersContent()
    {
        $lookups = [
            '5' => $this->performActiveUsersQuery('ga:7dayUsers', 5),
            '10' => $this->performActiveUsersQuery('ga:7dayUsers', 10),
            '15' => $this->performActiveUsersQuery('ga:7dayUsers', 15),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['seven-day-active-users'],
            [
                'results' => [0],
            ],
        );

        return $data;
    }

    public function getSevenDayActiveUsersContent(): array
    {
        return [
            'value' => FilamentGoogleAnalytics::for(last($this->initializeSevenDayActiveUsersContent()['results']))->trajectoryValue(),
            'color' => 'primary',
            'chart' => array_values($this->initializeSevenDayActiveUsersContent()['results'])
        ];
    }

    public function initializeFourteenDayActiveUsersContent()
    {
        $lookups = [
            '5' => $this->performActiveUsersQuery('ga:14dayUsers', 5),
            '10' => $this->performActiveUsersQuery('ga:14dayUsers', 10),
            '15' => $this->performActiveUsersQuery('ga:14dayUsers', 15),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['fourteen-day-active-users'],
            [
                'results' => [0],
            ],
        );

        return $data;
    }

    public function getFourteenDayActiveUsersContent(): array
    {
        return [
            'value' => FilamentGoogleAnalytics::for(last($this->initializeFourteenDayActiveUsersContent()['results']))->trajectoryValue(),
            'color' => 'primary',
            'chart' => array_values($this->initializeFourteenDayActiveUsersContent()['results'])
        ];
    }

    public function initializeTwentyEightDayActiveUsersContent()
    {
        $lookups = [
            '5' => $this->performActiveUsersQuery('ga:28dayUsers', 5),
            '10' => $this->performActiveUsersQuery('ga:28dayUsers', 10),
            '15' => $this->performActiveUsersQuery('ga:28dayUsers', 15),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['twenty-eight-day-active-users'],
            [
                'results' => [0],
            ],
        );

        return $data;
    }

    public function getTwentyEightDayActiveUsersContent(): array
    {
        return [
            'value' => FilamentGoogleAnalytics::for(last($this->initializeTwentyEightDayActiveUsersContent()['results']))->trajectoryValue(),
            'color' => 'primary',
            'chart' => array_values($this->initializeTwentyEightDayActiveUsersContent()['results'])
        ];
    }

    public function filters(): array
    {
        return [
            '5' => '5 Days',
            '10' => '10 Days',
            '15' => '15 Days',
        ];
    }
}

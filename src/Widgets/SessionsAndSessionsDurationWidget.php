<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Arr;

class SessionsAndSessionsDurationWidget extends BaseWidget
{
    use Traits\Sessions;
    use Traits\SessionsDuration;

    public ?array $filters = [
        'sessions' => 'T',
        'sessions-duration' => 'T',
    ];

    protected function getCards(): array
    {
        return [
            GoogleAnalyticsCard::make('Sessions', $this->getSessionsContent()['value'])
                ->id('sessions')
                ->color($this->getSessionsContent()['color'])
                ->description($this->getSessionsContent()['description'])
                ->descriptionIcon($this->getSessionsContent()['icon'])
                ->filters($this->filters()),
            GoogleAnalyticsCard::make('Avg. Sessions Duration', $this->getContent()['value'])
                ->id('sessions-duration')
                ->color($this->getContent()['color'])
                ->description($this->getContent()['description'])
                ->descriptionIcon($this->getContent()['icon'])
                ->filters($this->filters()),
        ];
    }

    public function updatedFilters($value, $key)
    {
        if ($key === 'sessions') {
            $this->filters['sessions'] = $value;
            $this->initializeSessionsContent();
        }

        if ($key === 'sessions-duration') {
            $this->filters['sessions-duration'] = $value;
            $this->initializeContent();
        }
    }

    public function initializeSessionsContent()
    {
        $lookups = [
            'T' => $this->sessionsToday(),
            'Y' => $this->sessionsYesterday(),
            'LW' => $this->sessionsLastWeek(),
            'LM' => $this->sessionsLastMonth(),
            'LSD' => $this->sessionsLastSevenDays(),
            'LTD' => $this->sessionsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['sessions'],
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
    public function getSessionsContent(): array
    {
        return [
            'value' => $this->initializeSessionsContent()->trajectoryValue(),
            'icon' => $this->initializeSessionsContent()->trajectoryIcon(),
            'color' => $this->initializeSessionsContent()->trajectoryColor(),
            'description' => $this->initializeSessionsContent()->trajectoryDescription(),
        ];
    }

    public function initializeContent()
    {
        $lookups = [
            'T' => $this->sessionDurationToday(),
            'Y' => $this->sessionDurationYesterday(),
            'LW' => $this->sessionDurationLastWeek(),
            'LM' => $this->sessionDurationLastMonth(),
            'LSD' => $this->sessionDurationLastSevenDays(),
            'LTD' => $this->sessionDurationLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filters['sessions-duration'],
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return FilamentGoogleAnalytics::for($data['result'])
            ->previous($data['previous'])
            ->format('%');
    }

    public function getContent(): array
    {
        return [
            'value' => Carbon::createFromTimestamp($this->initializeContent()->value)->toTimeString(),
            'icon' => $this->initializeContent()->trajectoryIcon(),
            'color' => $this->initializeContent()->trajectoryColor(),
            'description' => $this->initializeContent()->trajectoryDescription(),
        ];
    }

    public function filters(): array
    {
        return [
            'T' => 'Today',
            'Y' => 'Yesterday',
            'LW' => 'Last Week',
            'LM' => 'Last Month',
            'LSD' => 'Last 7 Days',
            'LTD' => 'Last 30 Days',
        ];
    }
}

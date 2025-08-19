<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAFilters;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAResponse;
use Illuminate\Contracts\Support\Htmlable;

class GASessionsByCountryOverview extends ChartWidget
{
    public ?string $filter = 'T';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = collect(GAResponse::sessionsByCountry($this->filter))
            ->filter(fn ($item, $key) => str($key)->doesntStartWith('total'))
            ->values()
            ->toArray();
        return [
            'labels' => array_keys(GAResponse::sessionsByCountry($this->filter)),
            'datasets' => [
                [
                    'label' => 'Country',
                    'data' => $data,
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'fill' => 'start',
                    'cutout' => '55%',
                    'hoverOffset' => 5,
                    'borderColor' => 'transparent',
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return GAFilters::common();
    }

    public function getHeading(): string | Htmlable | null
    {
        return __('filament-google-analytics::widgets.sessions_by_country');
    }

    protected function getOptions(): array | RawJs | null
    {
        return RawJs::make(<<<'JS'
            {
                animation: {
                    duration: 0,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                    hit: {
                        radius: 0,
                    },

                },
                maintainAspectRatio: false,
                borderRadius: 4,
                scaleBeginAtZero: true,
                radius: '85%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'left',
                        align: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
                    },
                },
                tooltips: {
                    enabled: false,
                },
            }
        JS);
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Livewire\Livewire;
use Illuminate\Support\Arr;
use Filament\Widgets\StatsOverviewWidget\Card;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;

class PageViewsStatsOverview extends Card
{
    use Traits\PageViews;

    protected ?string $id = 'page-views';

    public ?string $defaultFilter = 'T';

    public function filters(?array $filters = null): static
    {
        $this->filters = [
            'T' =>  __('Today'),
            'Y' =>  __('Yesterday'),
            'LW'    =>  __('Last Week'),
            'LM'    =>  __('Last Month'),
            'LSD'   =>  __('Last 7 Days'),
            'LTD'   =>  __('Last 30 Days'),
        ];

        return $this;
    }

    public function updatedFilters($filter,$key)
    {
        if($key === 'page-views')
        {
            $this->updateContent();
        }
    }

    public function updateContent()
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
            $this->defaultFilter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return $this->result($data['result'])
            ->previous($data['previous'])
            ->format('%');
    }

    public function result(?string $value = null)
    {
        return FilamentGoogleAnalytics::for($value);
    }

    public function color(?string $color = null): static
    {
        $this->color = $this->updateContent()->trajectoryColor();

        return $this;
    }

    public function description(?string $description = null): static
    {
        $this->description = $this->updateContent()->trajectoryDescription();

        return $this;
    }

    public function descriptionIcon(?string $descriptionIcon = null): static
    {
        $this->descriptionIcon = $this->updateContent()->trajectoryIcon();

        return $this;
    }

    public function value($value = null): static
    {
        $this->value = $this->updateContent()->value;

        return $this;
    }

}


<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Contracts\View\View;

class GoogleAnalyticsCard extends Card
{
    protected ?array $filters = null;

    public function filters(?array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): ?array
    {
        return $this->filters;
    }

    public function render(): View
    {
        return view('filament-google-analytics::google-analytics-card', $this->data());
    }
}

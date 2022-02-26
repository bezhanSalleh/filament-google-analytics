<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Contracts\View\View;

class GoogleAnalyticsCard extends Card
{
    public function render(): View
    {
        return view('filament-google-analytics::google-analytics-card', $this->data());
    }
}

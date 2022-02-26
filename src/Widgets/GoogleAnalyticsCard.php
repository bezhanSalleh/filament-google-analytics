<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use Illuminate\Contracts\View\View;
use Filament\Widgets\StatsOverviewWidget\Card;

class GoogleAnalyticsCard extends Card
{
    public function render(): View
    {
        return view('filament-google-analytics::google-analytics-card', $this->data());
    }
}

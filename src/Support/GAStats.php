<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Support;

use Filament\Widgets\StatsOverviewWidget\Stat;

class GAStats extends Stat
{
    protected string $view = 'filament-google-analytics::widgets.ga-stats';

    public string | null $filter = null;

    /**
     * @var array<int|string, string>|null
     */
    protected array|null $options = null;

    /**
     * @param array<int|string, string> | null $options
     */
    public function select(array | null $options, string | null $filter = null): static
    {
        $this->options = $options;
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): string | null
    {
        return $this->filter;
    }

    /**
     * @return array<int|string, string>|null
     */
    public function getOptions(): array | null
    {
        return $this->options;
    }
}

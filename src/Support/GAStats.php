<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Support;

use Filament\Widgets\StatsOverviewWidget\Stat;

class GAStats extends Stat
{
    protected string $view = 'filament-google-analytics::widgets.ga-stats';

    public ?string $filter = null;

    /**
     * @var array<int|string, string>|null
     */
    protected ?array $options = null;

    /**
     * @param  array<int|string, string> | null  $options
     */
    public function select(?array $options, ?string $filter = null): static
    {
        $this->options = $options;
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    /**
     * @return array<int|string, string>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }
}

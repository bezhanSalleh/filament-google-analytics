<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics\Support;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;

class GAStatsBuilder
{
    protected ?string $filter = null;

    /** @var array<int|string, string>|null */
    protected ?array $options = null;

    protected mixed $response = null;

    final public function __construct(
        protected string $heading,
        protected ?string $type = null
    ) {}

    public static function make(string $heading, ?string $type = null): static
    {
        return app(static::class, ['heading' => $heading, 'type' => $type]);
    }

    public function usingResponse(mixed $response): static
    {
        $this->response = $response;

        return $this;
    }

    /** @param array<int|string, string> | null $options */
    public function withSelectFilter(?array $options, ?string $filter = null): static
    {
        $this->options = $options;
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return array<int|string, string> | null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }

    public function resolve(): GAStats
    {
        if ($this->getResponse() instanceof FilamentGoogleAnalytics) {
            $value = blank($this->type)
                ? $this->getResponse()->trajectoryValue()
                : $this->getResponse()->trajectoryValueAsTimeString();

            return GAStats::make($this->getHeading(), $value)
                ->description($this->getResponse()->trajectoryDescription())
                ->descriptionIcon($this->getResponse()->trajectoryIcon())
                ->color($this->getResponse()->trajectoryColor())
                ->chart([$this->getResponse()->previous, $this->getResponse()->value])
                // ->icon($this->getResponse()->trajectoryIcon())
                ->chartColor($this->getResponse()->trajectoryColor())
                ->select($this->getOptions(), $this->getFilter());
        }

        $data = data_get($this->getResponse(), 'results');

        return GAStats::make($this->getHeading(), FilamentGoogleAnalytics::for(last($data))->trajectoryValue())
            ->chart($data)
            ->chartColor('primary')
            ->select($this->getOptions(), $this->getFilter());
    }
}

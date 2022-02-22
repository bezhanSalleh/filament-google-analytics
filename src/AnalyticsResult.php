<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

class AnalyticsResult
{
    public string $previous;
    public string $format;

    public function __construct(public ?string $value = null) {}

    public static function for(?string $value = null)
    {
        return new static($value);
    }

    public function result(?string $value = null)
    {
        $this->value = $value;

        return $this;
    }

    public function previous(string $previous)
    {
        $this->previous = $previous;

        return $this;
    }

    public function format(string $format)
    {
        $this->format = $format;

        return $this;
    }
}

<?php

namespace BezhanSalleh\GoogleAnalytics;

use Illuminate\Support\Carbon;

class GoogleAnalytics
{
    public int | float $previous = 0;

    public string $format;

    public function __construct(public int | float $value = 0) {}

    public static function for(int | float $value = 0): static
    {
        return app(static::class, [
            'value' => $value,
        ]);
    }

    public function previous(int | float $previous): static
    {
        $this->previous = $previous;

        return $this;
    }

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function compute(): int | float
    {
        return match (true) {
            $this->value == 0 && $this->previous == 0 => 0,
            $this->value > 0 && $this->previous == 0 => $this->value,
            $this->previous != 0 => round((($this->value - $this->previous) / $this->previous) * 100),
            default => 0,
        };
    }

    public function trajectoryValue(): int | string
    {
        if ($this->compute() == 0) {
            $this->previous = $this->value;
        }

        return static::thousandsFormater($this->value);
    }

    public function trajectoryValueAsTimeString(): string
    {
        return Carbon::createFromTimestampUTC($this->value)->toTimeString();
    }

    public function trajectoryLabel(): string
    {
        return match ($this->getSign()) {
            -1 => __('google-analytics::widgets.trending_down'),
            0 => __('google-analytics::widgets.steady'),
            1 => __('google-analytics::widgets.trending_up'),
            default => __('google-analytics::widgets.steady')
        };
    }

    public function trajectoryColor(): string
    {
        return match ($this->getSign()) {
            -1 => config('google-analytics.trending_down_color'),
            0 => config('google-analytics.trending_steady_color'),
            1 => config('google-analytics.trending_up_color'),
            default => config('google-analytics.trending_steady_color')
        };
    }

    public function trajectoryIcon(): string
    {
        return match ($this->getSign()) {
            1 => config('google-analytics.trending_up_icon'),
            -1 => config('google-analytics.trending_down_icon'),
            default => config('google-analytics.trending_steady_icon')
        };
    }

    public function trajectoryDescription(): string
    {
        return static::thousandsFormater(abs($this->compute())) . $this->format . ' ' . $this->trajectoryLabel();
    }

    public static function thousandsFormater(int | float $value): string | int
    {
        $number = (int) $value;

        if ($number > 1000) {
            $x = round($number);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = ['k', 'm', 'b', 't'];
            $x_count_parts = count($x_array) - 1;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');

            return $x_display . $x_parts[$x_count_parts - 1];
        }

        return $number;
    }

    protected function getSign(): int
    {
        return (int) match (true) {
            $this->compute() > 0 => 1,
            $this->compute() < 0 => -1,
            default => 0
        };
    }
}

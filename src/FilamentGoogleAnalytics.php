<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

class FilamentGoogleAnalytics
{
    public string $previous;
    public string $format;

    public function __construct(public ?string $value = null)
    {
    }

    public static function for(?string $value = null)
    {
        return new static($value);
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

    public function compute(): int
    {
        if ($this->value == 0 || $this->previous == 0 || $this->previous == null) {
            return 0;
        }

        return (($this->value - $this->previous) / $this->previous) * 100;
    }

    public function trajectoryValue()
    {
        return $this->thousandsFormater($this->value);
    }

    public function trajectoryLabel()
    {
        return match (gmp_sign($this->compute())) {
            -1 => 'Descrease',
            0 => 'Same',
            1 => 'Increase',
            default => 'Same'
        };
    }

    public function trajectoryColor()
    {
        return match (gmp_sign($this->compute())) {
            -1 => 'danger',
            0 => 'secondary',
            1 => 'success',
            default => 'secondary'
        };
    }

    public function trajectoryIcon()
    {
        return match (gmp_sign($this->compute())) {
            1 => 'heroicon-o-trending-up',
            -1 => 'heroicon-o-trending-down',
            default => 'heroicon-o-switch-horizontal'
        };
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function trajectoryDescription(): string
    {
        return $this->thousandsFormater($this->compute()) . $this->format . ' ' .$this->trajectoryLabel();
    }

    public function thousandsFormater($value)
    {
        $number = (int) $value;

        if ($number > 1000) {
            $x = round($number);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = ['k', 'm', 'b', 't'];
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $number;
    }
}

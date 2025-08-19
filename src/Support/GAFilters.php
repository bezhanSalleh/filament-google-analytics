<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics\Support;


final class GAFilters
{
    /**
     * @return array<int|string, string>
     */
    public static function activeUsers(): array
    {
        return [
            '5' => __('filament-google-analytics::widgets.FD'),
            '10' => __('filament-google-analytics::widgets.TD'),
            '15' => __('filament-google-analytics::widgets.FFD'),
        ];
    }

    /**
     * Provides a list of common filters for:
     *  - Page Views
     *  - Unique Visitors
     *  - Sessions
     *  - Sessions Duration
     *  - Sessions by Device and Country
     * @return array<string, string>
     */
    public static function common(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'Y' => __('filament-google-analytics::widgets.Y'),
            'LW' => __('filament-google-analytics::widgets.LW'),
            'LM' => __('filament-google-analytics::widgets.LM'),
            'LSD' => __('filament-google-analytics::widgets.LSD'),
            'LTD' => __('filament-google-analytics::widgets.LTD'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function mostVisitedAndTopReferrers(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'TW' => __('filament-google-analytics::widgets.TW'),
            'TM' => __('filament-google-analytics::widgets.TM'),
            'TY' => __('filament-google-analytics::widgets.TY'),
        ];
    }
}

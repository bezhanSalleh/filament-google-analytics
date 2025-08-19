<?php

declare(strict_types=1);

namespace BezhanSalleh\GoogleAnalytics\Support;

final class GAFilters
{
    /**
     * @return array<int|string, string>
     */
    public static function activeUsers(): array
    {
        return [
            '5' => __('google-analytics::widgets.FD'),
            '10' => __('google-analytics::widgets.TD'),
            '15' => __('google-analytics::widgets.FFD'),
        ];
    }

    /**
     * Provides a list of common filters for:
     *  - Page Views
     *  - Unique Visitors
     *  - Sessions
     *  - Sessions Duration
     *  - Sessions by Device and Country
     *
     * @return array<string, string>
     */
    public static function common(): array
    {
        return [
            'T' => __('google-analytics::widgets.T'),
            'Y' => __('google-analytics::widgets.Y'),
            'LW' => __('google-analytics::widgets.LW'),
            'LM' => __('google-analytics::widgets.LM'),
            'LSD' => __('google-analytics::widgets.LSD'),
            'LTD' => __('google-analytics::widgets.LTD'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function mostVisitedAndTopReferrers(): array
    {
        return [
            'T' => __('google-analytics::widgets.T'),
            'TW' => __('google-analytics::widgets.TW'),
            'TM' => __('google-analytics::widgets.TM'),
            'TY' => __('google-analytics::widgets.TY'),
        ];
    }
}

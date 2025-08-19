<?php

declare(strict_types=1);

namespace BezhanSalleh\GoogleAnalytics\Support;

use BezhanSalleh\GoogleAnalytics\Traits\ActiveUsers;
use BezhanSalleh\GoogleAnalytics\Traits\PageViews;
use BezhanSalleh\GoogleAnalytics\Traits\Sessions;
use BezhanSalleh\GoogleAnalytics\Traits\SessionsDuration;
use BezhanSalleh\GoogleAnalytics\Traits\Visitors;
use Carbon\Carbon;
use Spatie\Analytics\Period;

final class GADataLookups
{
    use ActiveUsers;
    use PageViews;
    use Sessions;
    use SessionsDuration;
    use Visitors;

    /** @return array<int, array<string, mixed>> */
    public function activeUsers(string $variant = 'active1DayUsers'): array
    {
        return match ($variant) {
            'active1DayUsers' => [
                '5' => $this->performActiveUsersQuery('active1DayUsers', 5),
                '10' => $this->performActiveUsersQuery('active1DayUsers', 10),
                '15' => $this->performActiveUsersQuery('active1DayUsers', 15),
            ],
            'active7DayUsers' => [
                '5' => $this->performActiveUsersQuery('active7DayUsers', 5),
                '10' => $this->performActiveUsersQuery('active7DayUsers', 10),
                '15' => $this->performActiveUsersQuery('active7DayUsers', 15),
            ],
            'active28DayUsers' => [
                '5' => $this->performActiveUsersQuery('active28DayUsers', 5),
                '10' => $this->performActiveUsersQuery('active28DayUsers', 10),
                '15' => $this->performActiveUsersQuery('active28DayUsers', 15),
            ],
            default => [
                '5' => $this->performActiveUsersQuery('active1DayUsers', 5),
                '10' => $this->performActiveUsersQuery('active1DayUsers', 10),
                '15' => $this->performActiveUsersQuery('active1DayUsers', 15),
            ],
        };
    }

    /**
     * @return array<string, Period>
     */
    public function mostVisitedAndTopReferrers(): array
    {
        return [
            'T' => Period::days(1),
            'TW' => Period::days(7),
            'TM' => Period::months(1),
            'TY' => Period::years(1),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function pageViews(): array
    {
        return [
            'T' => $this->pageViewsToday(),
            'Y' => $this->pageViewsYesterday(),
            'LW' => $this->pageViewsLastWeek(),
            'LM' => $this->pageViewsLastMonth(),
            'LSD' => $this->pageViewsLastSevenDays(),
            'LTD' => $this->pageViewsLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function sessions(): array
    {
        return [
            'T' => $this->sessionsToday(),
            'Y' => $this->sessionsYesterday(),
            'LW' => $this->sessionsLastWeek(),
            'LM' => $this->sessionsLastMonth(),
            'LSD' => $this->sessionsLastSevenDays(),
            'LTD' => $this->sessionsLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function sessionsDuration(): array
    {
        return [
            'T' => $this->sessionDurationToday(),
            'Y' => $this->sessionDurationYesterday(),
            'LW' => $this->sessionDurationLastWeek(),
            'LM' => $this->sessionDurationLastMonth(),
            'LSD' => $this->sessionDurationLastSevenDays(),
            'LTD' => $this->sessionDurationLastThirtyDays(),
        ];
    }

    /**
     * @return array<string, Period>
     */
    public function sessionsByDeviceAndByCountry(): array
    {
        return [
            'T' => Period::create(Carbon::yesterday(), Carbon::today()),
            'Y' => Period::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday()),
            'LW' => Period::create(
                Carbon::today()
                    ->clone()
                    ->startOfWeek(Carbon::SUNDAY)
                    ->subWeek(),
                Carbon::today()
                    ->clone()
                    ->subWeek()
                    ->endOfWeek(Carbon::SATURDAY)
            ),
            'LM' => Period::create(
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth(),
                Carbon::today()
                    ->clone()
                    ->startOfMonth()
                    ->subMonth()
                    ->endOfMonth()
            ),
            'LSD' => Period::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(6),
                Carbon::yesterday()
            ),
            'LTD' => Period::create(
                Carbon::yesterday()
                    ->clone()
                    ->subDays(29),
                Carbon::yesterday()
            ),
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function visitors(): array
    {
        return [
            'T' => $this->visitorsToday(),
            'Y' => $this->visitorsYesterday(),
            'LW' => $this->visitorsLastWeek(),
            'LM' => $this->visitorsLastMonth(),
            'LSD' => $this->visitorsLastSevenDays(),
            'LTD' => $this->visitorsLastThirtyDays(),
        ];
    }
}

<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Traits;

use App\FormatNumber;
use Illuminate\Support\Arr;
use Filament\Widgets\StatsOverviewWidget\Card;

trait OneDayActiveUsers
{
    use ActiveUsers;

    public ?string $oneDayDefaultFilter = '5RandowJumbo';
    public ?array $chartData = null;

    public function oneDayFilters(): array
    {
        return [
            '5RandowJumbo' => __('5 Days'),
            '10RandowJumbo' => __('10 Days'),
            '15RandowJumbo' => __('15 Days'),
        ];
    }

    public function oneDayUsers($value)
    {
        $lookups = [
            '5RandowJumbo' => $this->performActiveUsersQuery('ga:1dayUsers', 5),
            '10RandowJumbo' => $this->performActiveUsersQuery('ga:1dayUsers', 10),
            '15RandowJumbo' => $this->performActiveUsersQuery('ga:1dayUsers', 15),
        ];

        $this->oneDayDefaultFilter = $value;

        $data = Arr::get($lookups, $this->oneDayDefaultFilter , ['results' => [0]]);

        $this->chartData = array_values($data['results']);

        return $data;
    }

    public function oneDayStats()
    {
       $result = $this->oneDayUsers($this->oneDayDefaultFilter);
       $value = last($result['results']);
       return [
            'value' => FormatNumber::format($value),
            'color' => 'primary'
       ];
    }
    public function oneDayCard(): Card
    {
        return Card::make('1 Day Active Users', $this->oneDayStats()['value'])
            ->filters($this->oneDayFilters())
            ->chart($this->chartData)
            ->chartColor($this->oneDayStats()['color'])
            ->action('oneDayUsers');
    }
}

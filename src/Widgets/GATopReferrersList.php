<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\Support\GAFilters;
use BezhanSalleh\FilamentGoogleAnalytics\Support\GAResponse;
use BezhanSalleh\FilamentGoogleAnalytics\Support\SelectAction;
use BezhanSalleh\FilamentGoogleAnalytics\Traits\CanViewWidget;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class GATopReferrersList extends TableWidget
{
    use CanViewWidget;

    public ?string $filter = 'T';

    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('filament-google-analytics::widgets.top_referrers'))
            ->records(
                fn (): array => collect(GAResponse::topReferrers($this->filter))
                    ->mapWithKeys(fn (array $item): array => [str()->uuid()->toString() => $item])
                    ->toArray()
            )
            ->columns([
                Split::make([
                    TextColumn::make('url')
                        ->state(fn (array $record): string => filled($record['url']) ? $record['url'] : 'Unknown')
                        ->url(fn (array $record): ?string => filled($record['url']) && $record['url'] !== 'Unknown' ? $record['url'] : null)
                        ->openUrlInNewTab(fn (array $record): bool => filled($record['url']) && $record['url'] !== 'Unknown')
                        ->alignStart()
                        ->weight(FontWeight::Medium)
                        ->wrap(),
                    TextColumn::make('pageViews')
                        ->badge()
                        ->color('primary')
                        ->alignEnd()
                        ->grow(false),
                ]),
            ])
            ->extraAttributes([
                'class' => '[&_.fi-ta-record:not(:last-child)]:border-b [&_.fi-ta-record]:border-gray-200 dark:[&_.fi-ta-record]:border-gray-700 [&_.fi-ta-record-content-ctn]:py-2.5 [&_.fi-ta-text-item]:text-gray-700 dark:[&_.fi-ta-text-item]:text-gray-300 [&_.fi-ta-text-item]:hover:text-primary-500 dark:[&_.fi-ta-text-item]:hover:text-primary-400',
            ])
            ->headerActions([
                SelectAction::make('filter')
                    ->options(fn (): array => GAFilters::mostVisitedAndTopReferrers()),
            ])
            ->deferLoading();
    }
}

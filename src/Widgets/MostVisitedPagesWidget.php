<?php

namespace BezhanSalleh\GoogleAnalytics\Widgets;

use BezhanSalleh\GoogleAnalytics\Support\GAFilters;
use BezhanSalleh\GoogleAnalytics\Support\GAResponse;
use BezhanSalleh\GoogleAnalytics\Support\SelectAction;
use BezhanSalleh\GoogleAnalytics\Traits\CanViewWidget;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class MostVisitedPagesWidget extends TableWidget
{
    use CanViewWidget;

    public ?string $filter = 'T';

    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('google-analytics::widgets.most_visited_pages'))
            ->records(
                fn () => collect(GAResponse::mostVisitedPages($this->filter))
                    ->mapWithKeys(fn (array $item): array => [str()->uuid()->toString() => $item])
                    ->toArray()
            )
            ->columns([
                Split::make([
                    TextColumn::make('name')
                        ->url(fn (array $record): string => str($record['hostname'])->append($record['path'])->prepend('https://')->toUri())
                        ->openUrlInNewTab()
                        ->alignStart()
                        ->weight(FontWeight::Medium)
                        ->wrap(),
                    TextColumn::make('visits')
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

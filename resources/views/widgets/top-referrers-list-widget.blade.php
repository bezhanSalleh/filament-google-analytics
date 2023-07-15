<x-filament-widgets::widget class="filament-wigets-chart-widget">
    <x-filament::card>
        <div class="flex items-center justify-between gap-8">
                <x-filament::card.header>
                        <x-filament::card.heading>
                            {{ $this->getHeading() }}
                        </x-filament::card.heading>
                </x-filament::card.header>

                    <div class="flex items-center gap-3">
                        @if ($hasFilterLoadingIndicator)
                            <div wire:loading wire:target='filter'>
                                <x-filament-google-analytics::loading-indicator />
                            </div>
                        @endif

                        <select
                            class="block text-gray-900 transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none !focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-primary-500"
                            wire:model="filter"
                            wire:loading.class="animate-pulse"
                            style="padding-block: 4px"
                        >
                            @foreach ($filters as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div>

        <x-filament::hr />

        <div class="relative space-y-2 max-auto" wire:init='init'>
            <ul>
                @if ($readyToLoad)
                    @foreach ($data as $record)
                        <li @class([
                            'group border-gray-300 hover:border-primary-500',
                            'border-b' => !$loop->last,
                            'border-b-none' => $loop->last,
                            'dark:border-gray-700' => config('filament.dark_mode')
                        ])>
                            <div class="block p-2">
                                <div class="flex items-center justify-between">
                                    <h5 class="font-medium text-gray-500 dark:text-gray-300">{{ $record['url'] }}</h5>
                                    <span
                                        class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 whitespace-normal dark:text-primary-500">
                                        {{ FilamentGoogleAnalytics::thousandsFormater($record['pageViews']) }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <div class="flex justify-center items-center h-[270px] w-full">
                        <x-filament-google-analytics::loading-indicator />
                    </div>
                @endif
            </ul>
            <div wire:loading.delay.long wire:target='filter'>
                <div class="absolute inset-0">
                    <div class="flex items-center justify-center w-full h-full mx-auto"
                        wire:loading.delay.long.class='bg-[#ffffffccc]'>
                        <x-filament-google-analytics::loading-indicator />
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>

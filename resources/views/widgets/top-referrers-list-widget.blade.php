<x-filament::widget class="filament-wigets-chart-widget">
    <x-filament::card>
        <div class="flex items-center justify-between gap-8">
            <x-filament::card.heading class="text-gray-600 dark:text-white">
                {{ $this->getHeading() }}
            </x-filament::card.heading>

            <select wire:model="filter" @class([
                'text-sm font-medium text-gray-500 border-gray-300 block h-9 transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600',
                'dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200' => config(
                    'filament.dark_mode',
                ),
            ])>
                @foreach ($filters as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
            </select>
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
                                <div class="flex justify-between items-center">
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
                    <div class="flex justify-center items-center mx-auto h-full w-full"
                        wire:loading.delay.long.class='bg-[#ffffffccc]'>
                        <x-filament-google-analytics::loading-indicator />
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>

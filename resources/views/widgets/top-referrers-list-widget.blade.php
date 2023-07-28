<x-filament-widgets::widget class="filament-wigets-chart-widget">
    <x-filament::card class="fi-wi-chart grid gap-y-4">
        <div class="flex items-center gap-x-4">
            <div class="grid gap-y-1">
                <h3 class="text-base font-semibold leading-6">
                    {{ $this->getHeading() }}
                </h3>
            </div>
            <x-filament-forms::affixes inline-prefix wire:target="filter" class="ms-auto">
                <x-filament::input.select inline-prefix wire:model.live="filter">
                    @foreach ($filters as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                    @endforeach
                </x-filament::input.select>
            </x-filament-forms::affixes>
        </div>


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

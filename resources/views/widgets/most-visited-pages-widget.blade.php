<x-filament-widgets::widget>
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
                <li @class([ 'group border-gray-300 hover:border-primary-500' , 'border-b'=> !$loop->last,
                    'border-b-none' => $loop->last,
                    'dark:border-gray-700' => config('filament.dark_mode')
                    ])>
                    <div class="block p-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-start space-x-1 ">
                                <h5 class="font-medium text-gray-500 group-hover:text-primary-500 dark:text-gray-300">
                                    {{ $record['name'] }}
                                </h5>
                                <span class="text-sm text-gray-400 group-hover:text-primary-400">
                                    <a href="https://{{ $record['hostname'] . $record['path'] }}" target="_blank" class="flex items-center justify-start group-hover:text-primary-500">
                                        &NonBreakingSpace;{{ $record['path'] }}
                                        &NonBreakingSpace;
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                            <span class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 whitespace-normal dark:text-primary-500">
                                {{ FilamentGoogleAnalytics::thousandsFormater($record['visits']) }}
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
                    <div class="flex items-center justify-center w-full h-full mx-auto" wire:loading.delay.long.class='bg-[#ffffffccc]'>
                        <x-filament-google-analytics::loading-indicator />
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>

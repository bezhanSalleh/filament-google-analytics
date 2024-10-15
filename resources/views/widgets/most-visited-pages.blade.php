@php
    $color = $this->getColor();
    $filters = $this->getFilters();
    $heading = $this->getHeading();
@endphp

<div class="fi-wi-stats-overview-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <div class="grid gap-y-4">
        <div class="flex items-center gap-x-2">
            <span class="text-lg font-semibold text-gray-500 dark:text-gray-100">
                {{ $heading }}
            </span>
            @if ($filters)
                <x-filament::input.wrapper inline-prefix wire:target="filter" class="ms-auto">
                    <x-filament::input.select inline-prefix wire:model.live="filter">
                        @foreach ($filters as $val => $label)
                        <option value="{{ $val }}">
                            {{ $label }}
                        </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            @endif
        </div>

        <div class="relative space-y-2 max-auto">
            <ul class="divide-y divide-gray-300 dark:divide-gray-700">
                @foreach ($this->getCachedData() as $record)
                    <li class="group">
                        <div class="block p-2">
                            <div class="flex items-center justify-between gap-x-1">
                                <div class="flex items-center justify-start space-x-1 flex-wrap sm:flex-nowrap">
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-400">
                                        {{ $record['name'] }}
                                    </h5>
                                    <span class="text-xs text-gray-400">
                                        <a href="https://{{ $record['hostname'] . $record['path'] }}" target="_blank" class="flex items-center justify-start space-x-1 group-hover:text-primary-500 dark:group-hover:text-primary-400">
                                            <span>
                                                {{ $record['path'] }}
                                            </span>
                                            <x-filament::icon class="w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-primary-500 dark:group-hover:text-primary-400" icon="heroicon-s-arrow-top-right-on-square" />
                                        </a>
                                    </span>
                                </div>

                                <x-filament::badge :color="$color" class="tabular-nums shrink-0">
                                    {{ FilamentGoogleAnalytics::thousandsFormater($record['visits']) }}
                                </x-filament::badge>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

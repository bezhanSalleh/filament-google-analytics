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
                    <li class="flex flex-row items-center justify-between p-2 group gap-x-1">
                        <h5 class="grow text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-400 cursor-pointer truncate w-10 sm:w-full">{{ filled($record['url']) ? $record['url'] : 'Unknown' }}</h5>
                        <x-filament::badge :color="$color" class="tabular-nums shrink-0">
                            {{ FilamentGoogleAnalytics::thousandsFormater($record['pageViews']) }}
                        </x-filament::badge>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

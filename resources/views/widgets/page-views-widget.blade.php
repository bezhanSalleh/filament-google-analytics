<x-filament-widgets::widget class="filament-stats-overview-widget">
    <div @class(['filament-stats-overview-widget-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/20 h-[148px]'])>
        <div @class(['space-y-2'])>
            <div class="flex items-center gap-x-4">
                <div class="grid gap-y-1">
                    <h3 class="text-base font-semibold leading-6">
                        {{ $this->label() }}
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
            <div wire:init='init'>
                @if ($readyToLoad)
                    <div class="text-3xl">
                        {{ $data['value'] }}
                    </div>
                    <div
                        class="flex items-center space-x-1 text-sm font-medium text-custom-600 rtl:space-x-reverse"
                        style="{{ \Filament\Support\get_color_css_variables($data['color'] ?? 'gray', shades: [600]) }}"
                    >
                        <span>{{ $data['description'] }}</span>

                        <x-filament::icon
                                :name="$data['icon']"
                                alias="widgets::stats-overview.card.description"
                                size="h-4 w-4"
                            />
                    </div>
                @else
                    <div class="absolute inset-0 flex items-center justify-center bg-white/70 rounded-xl">
                        <div class="flex items-center justify-center w-12 h-12 text-primary-500">
                            <x-filament-google-analytics::loading-indicator />
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

</x-filament-widgets::widget>

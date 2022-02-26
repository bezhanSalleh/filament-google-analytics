<x-filament::widget class="filament-wigets-chart-widget">
    <x-filament::card>
        <div class="flex items-center justify-between gap-8">
            <x-filament::card.heading class="text-gray-600">
                {{ $this->getHeading() }}
            </x-filament::card.heading>

            <select wire:model="filter" @class([
                'text-sm font-medium text-gray-500 border-gray-300 block h-9 transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600',
                'dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200' => config(
                    'filament.dark_mode',
                ),
            ])>
                @foreach ($this->getFilters() as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <x-filament::hr />

        <ul class="space-y-2">
            @foreach ($this->getData() as $data)
                <li class="hover:bg-primary-50">
                    <a href="https://{{ $data['hostname'] . $data['path'] }}" target="_blank"
                        class="block p-2 border-b border-b-primary-500 group-hover:border-b-primary-500">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-start items-center space-x-1 ">
                                <h5 class="font-medium text-gray-500">
                                    {{ $data['name'] }}
                                </h5>
                                <span class="text-sm text-gray-400 group-hover:text-gray-600">
                                     - {{ $data['path'] }}
                                </span>
                            </div>
                            <span class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 whitespace-normal dark:text-primary-500">
                                {{ $data['visits'] }}
                            </span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </x-filament::card>
</x-filament::widget>

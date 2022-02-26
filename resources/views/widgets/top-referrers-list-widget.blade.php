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

        <div wire:loading.delay.long wire:target='filter'>
            Loading...
        </div>
        <ul class="space-y-2">

            @foreach ($this->getData() as $data)
                <li wire:loading.remove>
                    <div class="block p-2 border-b border-gray-700 hover:border hover:border-primary-600">
                        <div class="flex justify-between items-center">
                            <h5 class="font-medium text-gray-500">{{ $data['url'] }}</h5>
                            <span class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 whitespace-normal dark:text-primary-500">
                                {{ $data['pageViews'] }}
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </li>
    </x-filament::card>
</x-filament::widget>

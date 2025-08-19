<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Filament\Widgets\WidgetConfiguration;
use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;

class WidgetManager
{
    /**
     * @var array<string, string>
     */
    protected array $livewireComponents = [];

    /**
     * @var array<int, class-string>
     */
    protected array $widgets = [
        Widgets\GAPageViewsOverview::class,
        Widgets\GAUniqueVisitorsOverview::class,
        Widgets\GAActiveUsersOneDayOverview::class,
        Widgets\GAActiveUsersSevenDayOverview::class,
        Widgets\GAActiveUsersTwentyEightDayOverview::class,
        Widgets\GASessionsOverview::class,
        Widgets\GASessionsDurationOverview::class,
        Widgets\GASessionsByCountryOverview::class,
        Widgets\GASessionsByDeviceOverview::class,
        Widgets\GAMostVisitedPagesList::class,
        Widgets\GATopReferrersList::class,
    ];

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(): void
    {
        $this->enqueueWidgetsForRegistration();

        foreach ($this->livewireComponents as $componentName => $componentClass) {
            Livewire::component($componentName, $componentClass);
        }

        $this->livewireComponents = [];
    }

    protected function enqueueWidgetsForRegistration(): void
    {
        foreach ($this->widgets as $widget) {
            $this->queueLivewireComponentForRegistration($this->normalizeWidgetClass($widget));
        }
    }

    /**
     * @param  class-string | WidgetConfiguration  $widget
     * @return class-string
     */
    public function normalizeWidgetClass(string | WidgetConfiguration $widget): string
    {
        if ($widget instanceof WidgetConfiguration) {
            return $widget->widget;
        }

        return $widget;
    }

    protected function queueLivewireComponentForRegistration(string $component): void
    {
        $componentName = app(ComponentRegistry::class)->getName($component);

        $this->livewireComponents[$componentName] = $component;
    }
}

<?php

declare(strict_types=1);

namespace BezhanSalleh\GoogleAnalytics;

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
        Widgets\PageViewsWidget::class,
        Widgets\VisitorsWidget::class,
        Widgets\ActiveUsersOneDayWidget::class,
        Widgets\ActiveUsersSevenDayWidget::class,
        Widgets\ActiveUsersTwentyEightDayWidget::class,
        Widgets\SessionsWidget::class,
        Widgets\SessionsByCountryWidget::class,
        Widgets\SessionsDurationWidget::class,
        Widgets\SessionsByDeviceWidget::class,
        Widgets\MostVisitedPagesWidget::class,
        Widgets\TopReferrersListWidget::class,
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
        $componentName = $this->getComponentAlias($component);

        $this->livewireComponents[$componentName] = $component;
    }

    private function getComponentAlias(string $component): string
    {
        if (app()->has(ComponentRegistry::class)) {

            return app(ComponentRegistry::class)->getClass($component);
        }

        return app('livewire.finder')->resolveClassComponentClassName($component);
    }
}

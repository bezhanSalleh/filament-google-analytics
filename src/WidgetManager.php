<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Filament\Widgets\WidgetConfiguration;
use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;

class WidgetManager
{
    /**
     * @var array<string, class-string>
     */
    protected array $livewireComponents = [];

    protected array $widgets = [
        Widgets\PageViewsWidget::class,
        Widgets\VisitorsWidget::class,
        Widgets\ActiveUsersOneDayWidget::class,
        Widgets\ActiveUsersSevenDayWidget::class,
        Widgets\ActiveUsersTwentyEightDayWidget::class,
        Widgets\SessionsWidget::class,
        Widgets\SessionsDurationWidget::class,
        Widgets\SessionsByCountryWidget::class,
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
     * @param  class-string<Widget> | WidgetConfiguration  $widget
     * @return class-string<Widget>
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

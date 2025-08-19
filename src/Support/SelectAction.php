<?php

declare(strict_types=1);

namespace BezhanSalleh\GoogleAnalytics\Support;

use Filament\Actions\SelectAction as BaseSelectAction;
use Filament\Support\Enums\IconSize;
use Illuminate\View\ComponentAttributeBag;

use function Filament\Support\generate_loading_indicator_html;

class SelectAction extends BaseSelectAction
{
    public function toEmbeddedHtml(): string
    {
        $id = $this->getId();
        $isDisabled = $this->isDisabled();
        $name = $this->getName();

        $componentAttributeBag = (new ComponentAttributeBag)
            ->class([
                'fi-input-wrp relative',
                'fi-disabled' => $isDisabled,
            ]);

        $inputAttributes = (new ComponentAttributeBag)
            ->merge([
                'disabled' => $isDisabled,
                'id' => $id,
                'wire:model.live' => $name,
                // 'wire:loading.attr' => 'disabled',
                'wire:loading.class' => 'pl-8',
                'wire:target' => $name,
            ], escape: false)
            ->class([
                'fi-select-input',
                'pr-8',
            ]);

        // Spinner attributes respecting the delay
        $spinnerAttributes = (new ComponentAttributeBag)
            ->merge([
                'wire:loading.flex' => true,
                'wire:loading.class.remove' => 'hidden',
                'wire:target' => $name,
            ], escape: false)
            ->class([
                'absolute hidden items-center justify-center w-4 h-4 -translate-y-1/2 pointer-events-none left-2 top-1/2',
            ]);

        ob_start(); ?>

        <div class="fi-ac-select-action">
            <label for="<?= $id ?>" class="fi-sr-only">
                <?= e($this->getLabel()) ?>
            </label>

            <div <?= $componentAttributeBag->toHtml() ?>>
                <select <?= $inputAttributes->toHtml() ?>>
                    <?php if (($placeholder = $this->getPlaceholder()) !== null) { ?>
                        <option value=""><?= e($placeholder) ?></option>
                    <?php } ?>
                    <?php foreach ($this->getOptions() as $value => $label) { ?>
                        <option value="<?= e($value) ?>"><?= e($label) ?></option>
                    <?php } ?>
                </select>

                <!-- absolutely positioned spinner, respects Livewire delay -->
                <div <?= $spinnerAttributes->toHtml() ?> aria-hidden="true">
                    <?= generate_loading_indicator_html(
                        new ComponentAttributeBag([
                            'class' => 'text-gray-400 dark:text-gray-300',
                        ]),
                        IconSize::Medium
                    )->toHtml(); ?>
                </div>
            </div>
        </div>

        <?php return ob_get_clean() ?: '';
    }
}

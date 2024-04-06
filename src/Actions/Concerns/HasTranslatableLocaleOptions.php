<?php

namespace Filament\Actions\Concerns;

use Filament\SpatieLaravelTranslatablePlugin;

trait HasTranslatableLocaleOptions
{
    public function setTranslatableLocaleOptions(): static
    {
        $this->options(function (): array {
            $livewire = $this->getLivewire();

            if (! method_exists($livewire, 'getTranslatableLocales')) {
                return [];
            }

            $locales = [];

            /** @var SpatieLaravelTranslatablePlugin $plugin */
            $plugin = filament('spatie-laravel-translatable');

            // foreach ($livewire->getTranslatableLocales() as $locale) { // оригинальная строка
            foreach ($livewire->getTranslatableLocales() as $key => $locale) { // Изменено Racter. Перебор исходного массива с языками, где ключик является расшифровкой локали, а значение - это локаль.
                $locales[$locale] = $plugin->getLocaleLabel($locale) ?? $locale; // Оригинальная строка, вместо конструкции с if. Создание массива языков, где ключик - язык, а значение - его полное название, метод плагин getLocaleLabel(); //- переводит ключик (код языка) в полное название языка на языке сайта, если заменить его на null - в значении используются только сокращения
                if (is_string($key)) { // Добавлено Racter. Если ключик - это строка...
                    $locales[$locale] = $key;
                } //далее см. в файле SpatieLaravelTranslatablePlugin.php
            }

            return $locales;
        });

        return $this;
    }
}

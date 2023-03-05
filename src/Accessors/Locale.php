<?php

declare(strict_types=1);

namespace MetaFramework\Accessors;

class Locale
{
    public static function multilang(): bool
    {
        return cache()->rememberForever('metaframework.multilang', fn() => config('metaframework.translatable.multilang'));
    }

    public static function locale(): string
    {
        return app()->getLocale();
    }

    public static function locales(): array
    {
        return config('metaframework.translatable.locales');
    }

    public static function activeLocales(): array
    {
        return config('metaframework.translatable.active_locales');
    }

    public static function defaultLocale(): string
    {
        return config('app.fallback_locale');
    }

    public static function localesAsSelectable(): array
    {
        return collect(trans('lang'))->sortBy('code')->pluck('label', 'code')->toArray();
    }

    public static function alternateIsoLocales(): array
    {
        return collect(config('metaframework.translatable.active_locales'))->reject(function ($item) {
            return $item == app()->getLocale();
        })->values()->toArray();
    }

    public static function openGraphAlternateLocales(): string
    {
        $output = '';

        foreach (config('metaframework.translatable.active_locales') as $locale) {
            $output.= '<link rel="alternate" hreflang="'.$locale.'" href="'.url($locale).'" />'."\n";
            if ($locale == app()->getLocale()) {
                $output.= '<link rel="alternate" hreflang="x-default" href="'.url($locale).'" />'."\n";
                $output.= '<meta property="og:locale" content="'.$locale.'" />'."\n";
            } else {
                $output.= '<meta property="og:locale:alternate" content="'.$locale.'" />'."\n";
            }

        }
        return trim($output);
    }

    public static function projectLocales(): array
    {
        return config('metaframework.translatable.locales');
    }

}

<?php

declare(strict_types=1);

namespace MetaFramework\Traits;

use Spatie\Translatable\HasTranslations;

use MetaFramework\Accessors\Locale;

trait Translation
{
    use HasTranslations;

    public array $translatable;
    private object $updatable;

    public function translation(string $key, string $locale = null): mixed
    {
        if (Locale::multilang()) {
            $locale = $locale ?? app()->getLocale();
            if (array_key_exists($key, $this->getTranslations())) {
                return $this->getTranslation($key, $locale);
            }
            return '';
        }

        if (str_contains($key, '.')) {
            $arrayable = explode('.', $key);
            $var = array_shift($arrayable);

            switch (count($arrayable)) {
                case 1:
                    return $this->{$var}[$arrayable[0]];
                case 2:
                    return $this->{$var}[$arrayable[0]][$arrayable[1]];
                case 3:
                    return $this->{$var}[$arrayable[0]][$arrayable[1]][$arrayable[2]];
                case 4:
                    return $this->{$var}[$arrayable[0]][$arrayable[1]][$arrayable[2]][$arrayable[3]];
                case 5:
                    return $this->{$var}[$arrayable[0]][$arrayable[1]][$arrayable[2]][$arrayable[3]][$arrayable[4]];
            }

        }
        return $this->{$key} ?? '';
    }

    public function translatableInput(string $name, string $locale = null): string
    {
        if (Locale::multilang()) {
            return $name . '[' . $locale ?: Locale::locale() . ']';
        }

        return $name;
    }

    public function translatableFromRequest(string $key, string $locale = null): mixed
    {
        if (Locale::multilang()) {
            return request($key . '.' . $locale);
        }

        return request($key);
    }

    protected function defineTranslatables(): static
    {
        $this->translatable = array_keys($this->fillables);
        return $this;
    }

    public function saveTranslation($key, $locale, $value): void
    {
        Locale::multilang()
            ? $this->setTranslation($key, $locale, $value)
            : $this->{$key} = $value;
    }


}

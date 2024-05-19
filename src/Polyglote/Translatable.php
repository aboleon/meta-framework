<?php

/*
The MIT License (MIT)

Copyright (c) Spatie bvba info@spatie.be
https://github.com/spatie/laravel-translatable (as per version 6.3)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

namespace Aboleon\MetaFramework\Polyglote;

use Closure;

class Translatable
{
    /*
     * If a translation has not been set for a given locale, use this locale instead.
     */
    public ?string $fallbackLocale;

    /*
     * If a translation has not been set for a given locale and the fallback locale,
     * any other locale will be chosen instead.
     */
    public bool $fallbackAny = false;

    public ?Closure $missingKeyCallback = null;

    public function fallback(
        ?string $fallbackLocale = null,
        ?bool $fallbackAny = false,
                $missingKeyCallback = null
    ): self {
        $this->fallbackLocale = $fallbackLocale;
        $this->fallbackAny = $fallbackAny;
        $this->missingKeyCallback = $missingKeyCallback;

        return $this;
    }
}
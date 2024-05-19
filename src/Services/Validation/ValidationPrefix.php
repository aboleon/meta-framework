<?php

namespace Aboleon\MetaFramework\Services\Validation;

trait ValidationPrefix
{
    private string $prefix;


    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix . '.';
        return $this;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

}
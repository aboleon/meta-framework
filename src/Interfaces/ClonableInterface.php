<?php

namespace MetaFramework\Interfaces;

interface ClonableInterface
{
    public function cloneSchema(): array;
    public function cloneLimit(): int ;
}


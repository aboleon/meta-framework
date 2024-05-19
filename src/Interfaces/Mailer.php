<?php

namespace Aboleon\MetaFramework\Interfaces;

interface Mailer
{

    public function send();
    public function email(): string|array;
    public function subject(): string;
    public function view(): string;

}

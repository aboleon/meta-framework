<?php

namespace MetaFramework\Traits;

trait Validation
{
    protected array $validation_rules = [];
    protected array $validation_messages = [];
    protected array $validated_data = [];

    protected function validation()
    {
        if ($this->validation_rules) {
            $this->validated_data = request()->validate(
                $this->validation_rules,
                $this->validation_messages
            );
        }
    }
}

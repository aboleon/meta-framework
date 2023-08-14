<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Functions\Helpers;

class Radio extends Component
{
    private string $validation_id;

    public function __construct(
        public array           $values,
        public string          $name,
        public int|string|null $affected,
        public string|null     $label = '',
        public int|string|null $default = null
    )
    {
        $this->validation_id = Helpers::generateValidationId($this->name);
    }

    public function render(): Renderable
    {
        return view('mfw::components.radio')
            ->with([
                'validation_id' => $this->validation_id,
            ]);
    }
}

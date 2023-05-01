<?php

namespace MetaFramework\Mediaclass\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Mediaclass\Parser;

class Printer extends Component
{
    private \MetaFramework\Mediaclass\Printer $printer;
    private array $allowed_types = [
        'img',
        'url'
    ];

    public string $html = '';

    public function __construct(
        public Parser $media,
        public string $size = 'sm',
        public string $type = 'img',
        public array  $params = [],
        public bool   $default = true,
    )
    {
        $this->printer = new \MetaFramework\Mediaclass\Printer($media);

        $this->printer->setSize($this->size);
        if (!$this->default) {
            $this->printer->noDefault();
        }
        if ($this->params) {
            $this->printer->setParams($this->params);
        }
        if (in_array($this->type, $this->allowed_types)) {
            $this->html = $this->printer->{$type}();
        }
    }

    public function render(): Renderable
    {
        return view('mediaclass::components.printer');
    }

}

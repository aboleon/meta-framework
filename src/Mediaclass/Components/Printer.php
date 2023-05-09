<?php

namespace MetaFramework\Mediaclass\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Mediaclass\Config;
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
        public mixed       $model = null,
        public string      $size = 'sm',
        public string      $type = 'img',
        public ?string     $class = null,
        public ?string     $alt = null,
        public array       $param = [],
        public string|bool $default = true,
        public bool        $responsive = true,
        public bool        $debug = false,
    )
    {
        if ($this->class) {
            $this->param['class'] = $this->class;
        }
        if ($this->alt) {
            $this->param['alt'] = $this->alt;
        }

        if ($this->model instanceof Parser) {

            $this->printer = new \MetaFramework\Mediaclass\Printer($model);

            $this->printer->setSize($this->size);

            if ($this->responsive === false) {
                $this->printer->disableResponsive();
            }

            if (!$this->default) {
                $this->printer->noDefault();
            }
            if ($this->param) {
                $this->printer->setParams($this->param);
            }
            if (in_array($this->type, $this->allowed_types)) {
                $this->html = $this->printer->{$type}();
            }
        } else {
            if ($this->default) {
                if ($this->type == 'url') {
                    $this->html = is_string($this->default) ? $this->default : Config::defaultImgUrl();
                } else {
                    $this->html = '<img src="' . (is_string($this->default) ? $this->default : Config::defaultImgUrl()) . '" ' . $this->renderParams() . '/>';
                }
            }

        }
    }

    public function render(): Renderable
    {
        return view('mediaclass::components.printer')->with('html', $this->html);
    }

    protected function renderParams(): string
    {
        $html = '';
        if (!array_key_exists('alt', $this->param)) {
            $this->param['alt'] = config('app.name');
        }
        foreach ($this->param as $key => $value) {
            $html .= $key . '="' . $value . '" ';
        }

        return $html;
    }

}

<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Aboleon\MetaFramework\Interfaces\CmsInterface;

class CmsConfigParser extends Component
{
    public array $config = [];
    public function __construct(
        public CmsInterface $model,
        public array $only = [],
        public array $exclude = []
    )
    {
        $this->config = $this->model->configCms();

        if ($this->only && !$this->except) {
            $this->config = array_filter($this->config, fn($item) => in_array($item, $this->only), ARRAY_FILTER_USE_KEY);
        }
        if ($this->exclude && !$this->only) {
            $this->config = array_filter($this->config, fn($item) => !in_array($item, $this->exclude), ARRAY_FILTER_USE_KEY);
        }
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.cms-config-parser')->with([
            'config' => $this->config,
        ]);
    }
}

<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use MetaFramework\Interfaces\GooglePlacesInterface;

class GooglePlaces extends Component
{
    /**
     * $params[] sert à ajouter des params suppl. à l'url JS de Google,
     * exemple :
     *      [types => (cities)]
     */

    public Collection $required;

    public function __construct(
        public GooglePlacesInterface $geo,
        public string                $field = 'wa_geo',
        public string                $random_id = '',
        public array                 $params = [],
        public string                $placeholder = '',
        public string                $tag_required = 'required',
        public ?string               $label = null
    )
    {
        $this->random_id = Str::random(4);
        $this->required = collect($this->params['required'] ?? []);
    }

    public function render(): Renderable
    {
        return view('mfw::components.google-places');
    }

    public function tagRequired(string $key): string
    {
        return $this->required->contains($key) ? $this->tag_required : '';
    }

    public function labelRequired(string $key): string
    {
        return $this->required->contains($key) ? ' *': '';
    }
}

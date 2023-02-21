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

    public function __construct(
        public GooglePlacesInterface $geo,
        public Collection            $required,
        public string                $field = 'wa_geo',
        //public array                 $countries = [],
        public string                $random_id = '',
        public array                 $params = [],
        public string                $placeholder = '',
        public string                $tag_required = 'required',
        public ?string               $label = null
    )
    {
        //$this->countries = static::countries();
        $this->random_id = Str::random(4);
        $this->required = collect($this->params['required'] ?? []);
    }

    public function render(): Renderable
    {
        return view('metaframework::components.google-places');
    }

    public function tagRequired(string $key): string
    {
        return $this->required->contains($key) ? $this->tag_required : '';
    }
}

<?php

namespace MetaFramework\Models;

use MetaFramework\Polyglote\Traits\Translation;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use Translation;

    public $timestamps = false;
    public array $translatable;
    public array $fillables = [
        'name' =>[
            'type' => 'text',
            'label' => 'Intitulé',
        ],
    ];
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->translatable = array_keys($this->fillables);
    }
}

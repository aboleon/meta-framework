<?php

namespace MetaFramework\Models\Meta;

use MetaFramework\Abstract\MetaModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryExample extends MetaModel
{
    public static string $signature = 'category-example';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillables = [
            '_media' => [
                'group' => 'header',
                'label' => 'Image bandeau'
            ],
            'meta[abstract]' => [
                'type' => 'textarea',
                'class' => 'simplified',
                'label' => 'Descriptif '
            ],
        ];
        $this->uses['parent'] = true;
        $this->disabled_meta = ['taxonomy'];
        $this->buttons['index'] = route('panel.category_example.index');

        $this->defineTranslatables();
    }

    public function pages(): BelongsToMany
    {
        /* Marche aussi
        return $this->hasManyThrough(SubModelExample::class, CategoryExample::class, 'category_id','id','id', 'category_id');
        */
        return $this->belongsToMany(SubModelExample::class, 'submodel_category-example', 'category_id', 'submodel_id', 'id', 'id');

    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent')->with('children')->withCount('submodels');
    }
}

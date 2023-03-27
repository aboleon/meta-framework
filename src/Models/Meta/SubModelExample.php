<?php

namespace MetaFramework\Models\Meta;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MetaFramework\Abstract\MetaModel;
use MetaFramework\Models\MetaBloc;

class SubModelExample extends MetaModel
{

    public static string $signature = 'submodel-example';

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);


        $this->fillables = [
            'meta[content]' => [
                'type' => 'textarea',
                'class' => 'extended',
                'label' => 'Texte'
            ],
        ];

        $this->reliesOnMeta();
        $this->hasBlocs();

        $this->disabled_meta = [
            'taxonomy'
        ];

        $this->defineTranslatables();
    }

    public function blocs(): HasMany
    {
        return $this->hasMany(MetaBloc::class, 'parent');
    }


    public function store(): static
    {
        $this->updateCategory();
        return $this;
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(CategoryExample::class, 'submodel_category_example','submodel_id', 'category_id','id', 'id');
    }

    /**
     * @param $query
     * @param \MetaFramework\Models\Meta\CategoryExample|null $category
     */
    public function scopeOfCategory($query, ?CategoryExample $category): Builder
    {
        /** @var MetaModel $category */
        if ($category) {
            $query->whereRelation('category', 'category_id', $category->id);
        }
        return $query;
    }

    private function updateCategory(): void
    {
        $this->category()->sync(request('category'));
    }
}
<?php

namespace MetaFramework\Models;

use MetaFramework\Abstract\MetaModel;
use Illuminate\Support\Str;

class MetaSubModel
{
    public string $subModelClass;
    public MetaModel $subModel;

    public function __construct(public Meta $meta)
    {
        $this->subModelClass = ($this->meta->type == 'bloc' && !empty($this->meta->taxonomy))
            ? $this->meta->taxonomy
            : '\App\Models\Meta\\' . Str::studly($this->meta->type);

        $this->subModel = class_exists($this->subModelClass)
            ? new $this->subModelClass
            : new DefaultProxy;

        if (
            $this->meta->id &&
            ($this->subModel instanceof DefaultProxy === false) &&
            !$this->subModel->uses['meta_model']
        ) {
            $this->subModel = $this->subModel->where('meta_id', $this->meta->id)->first() ?? $this->subModel;
        }
    }

    public function hasContent(): bool
    {
        return (bool)$this->subModel->id;
    }


    /**
     * Traitement DB par défaut basé sur la seule configuration du Meta model
     */
    public function process(): static
    {
        if (!$this->subModel->reliesOnMeta()) {

            $data = [];
            $this->unsetMetaAsTransltable();

            foreach ($this->subModel->translatable as $key) {
                $data[$key] = request($this->subModel::getSignature() . '.' . $key);
            }
            $this->subModel->updateOrCreate(['meta_id' => $this->meta->id], $data);
        }
        if (method_exists($this->subModel, 'store')) {
            $this->subModel->store();
        }

        return $this;
    }

    public function unsetMetaAsTransltable(): static
    {
        $this->subModel->translatable = array_filter($this->subModel->translatable, fn($item) => !str_starts_with($item, 'meta['));
        return $this;
    }

    public function model(): MetaModel
    {
        return $this->subModel;
    }
}

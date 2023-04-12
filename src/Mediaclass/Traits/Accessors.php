<?php

namespace MetaFramework\Mediaclass\Traits;

trait Accessors
{

    /**
     * Retourne Meta/Model
     */
    public function bindedModel(): object
    {
        return $this->model->model()->instance;
    }

    public function settings(): array
    {
        if (!is_array($this->bindedModel()->fillables)) {
            return [];
        }
        return (array)current(array_filter(array_filter($this->bindedModel()->fillables, fn($key) => $key == '_media', ARRAY_FILTER_USE_KEY), fn($item) => ($item['group'] ?? \MetaFramework\Mediaclass\Accessors\Mediaclass::defaultGroup()) == $this->group));
    }

}

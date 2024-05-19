<?php

namespace Aboleon\MetaFramework\Traits;

use Aboleon\MetaFramework\Models\Meta;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait MetaParams
{

    public bool $is_single = false;
    public bool $store_content_as_json = false;

    public array $uses = [
        'template' => false,
        'template_file' => false,
        'forms' => false,
        'meta_model' => true,
        'images' => true,
        'parent' => false,
        'blocs' => false,
        'meta' => true
    ];

    public array $urls = [
        'prefix' => false,
        'show' => false,
        'index' => false
    ];

    public array $buttons = [
        'status' => true,
        'create' => true,
        'index' => true
    ];

    public array $model_configs = [];
    public array $disabled_meta = [];
    public array $fillables = [];

    public array $configurables = [
        'template',
        'template_file',
        'forms',
        'parent'
    ];

    /**
     * @throws \Exception
     */
    public function visibility(string $key): string
    {
        if ($this->isHidden($key)) {
            return ' d-none';
        }
        return '';
    }

    /**
     * @throws \Exception
     */
    public function isHidden(string $key): string
    {
        return in_array($key, $this->disabled_meta);
    }

    /**
     * @throws \Exception
     */
    public function isVisible(string $key): string
    {
        return !$this->isHidden($key);
    }

    public function meta(): BelongsTo
    {
        return $this->belongsTo(Meta::class, 'meta_id');
    }

    public function editable(Meta $meta): static|null
    {
        return static::where('meta_id', $meta->id)->first();
    }

    public function hasForms(): void
    {
        $this->uses['forms'] = true;
    }

    public function isUsingForms(): bool
    {
        return $this->uses['forms'] === true;
    }

    public function hasBlocs(): void
    {
        $this->uses['blocs'] = true;
    }

    public function isUsingBlocs(): bool
    {
        return $this->uses['blocs'] === true;
    }

    public function isReliyingOnMeta(): bool
    {
        return $this->getTable() == (new Meta())->getTable();
    }

    public function storeMetaContentAsJson(): void
    {
        $this->store_content_as_json = true;
    }

    public function isStoringMetaContentAsJson(): bool
    {
        return $this->store_content_as_json === true;
    }

    /**
     * Vérifie si le Model utilise une configuration / paramétrage donné
     * @throws \Exception
     */
    public function uses(string $key): bool
    {
        return $this->uses[$key] ?? false;
    }

    /**
     * Vérifie si le Model utilise au moins un paramétrage
     * @throws \Exception
     */
    public function hasParams(): bool
    {
        return (bool)array_filter($this->configurables, fn($item) => !empty($this->uses[$item]));
    }

    /**
     * Vérifie si le Model utilise au moins un paramétrage
     * @throws \Exception
     */
    public function hasImage(): bool
    {
        return $this->uses('images');
    }

    /**
     * Vérifie si le Model utilise au moins un paramétrage
     * @throws \Exception
     */
    public function disableImage(): void
    {
        $this->uses['images'] = false;
    }
}

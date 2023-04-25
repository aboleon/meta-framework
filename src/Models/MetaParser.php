<?php

namespace MetaFramework\Models;

use MetaFramework\Accessors\Locale;
use MetaFramework\Mediaclass\Accessors\Mediaclass;
use MetaFramework\Mediaclass\Facades\MediaclassFacade;

class MetaParser
{

    private object $model;
    private mixed $content;
    private mixed $content_value;
    private string $uuid = '';
    private int $iterable = 1;
    private int $iteration;
    private Mediaclass $media;
    private array $data = [];

    public function __construct(
        public Meta    $meta,
        public ?string $locale = null,
    )
    {
        $this->model = $this->meta->subModel();
        $this->content = $this->model;

        if ($this->model->isReliyingOnMeta()) {
            $this->content = $this->model->isStoringMetaContentAsJson() ? json_decode($this->meta->content, true) : $this->meta;
        }
        $this->model->getFillables();

        $this->locale ??= app()->getLocale();

    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    public function parseFillables(): self
    {
        $this->media = MediaclassFacade::forModel($this->model);

        if (!$this->model->fillables) {
            return $this;
        }

        foreach ($this->model->fillables as $key => $collection) {

            $this->iterable = (int)$collection['repeatable'] ??= 1;
            $clonable = $collection['clonable'] ?? false;
            $schema = isset($collection['schema']);

            $key_content = (is_array($this->content) && array_key_exists($key, $this->content))
                ? $this->content[$key]
                : ($this->content->{$key} ?? null);

            if ($clonable) {
                $this->iterable = is_countable($key_content) ? count($key_content) : 1;
            }

            if ($schema) {
                $schema_collection = [
                    'label' => $collection['label']
                ];
                $this->data[$key]['label'] = $schema_collection;
            }


            for ($i = 0; $i < $this->iterable; ++$i) {

                $this->iteration = $i;

                $this->uuid = '';
                $found_content = $this->content;
                $is_meta = str_starts_with($key, 'meta[');

                if ($is_meta) {
                    $key = str_replace(['meta[', ']'], '', $key);
                    $found_content = $this->content->{$key};
                }

                if ($schema && is_array($key_content)) {
                    $this->uuid = key($key_content);
                    $found_content = is_array(current($key_content)) ? array_shift($key_content) : $key_content;
                }
                $this->content_value = ($key != 'media')
                    ? (
                    Locale::multilang()
                        ? $this->content->translation($key, $this->locale)
                        : ($this->content[$key] ?? null)
                    )
                    : null;

                if ($schema) {
                    foreach ($collection['schema'] as $subkey => $value) {

                        $this->content_value = Locale::multilang()
                            ? ($found_content[$subkey][$this->locale] ?? '')
                            : ($found_content[$subkey] ?? '');

                        $this->parseContent(key: $key, subkey: $subkey, data: $value, content: $this->content_value);
                    }
                } else {
                    $this->parseContent(key: $key, subkey: $key, data: $collection, content: $this->content_value);
                }
            }
        }

        return $this;
    }

    private function parseContent(string $key, string $subkey, array $data, mixed $content): self
    {
        $type = $data['type'] ??= 'text';

        if ($this->iterable > 1) {
            $this->data[$key]['entries'][$this->iteration][$subkey] = ($type == 'media' ? $this->media->forSubGroup($this->uuid)->toArray() : $content );

        } else {
            $this->data[$key] = ($type == 'media' ? $this->media->forGroup($data['group'] ?? 'media')->toArray() : $content);
        }
        return $this;
    }

}
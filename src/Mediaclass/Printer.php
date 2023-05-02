<?php

namespace MetaFramework\Mediaclass;

class Printer
{


    /**
     * Defaut image url
     */
    protected string $default_img;

    /*
     * Should be the default image URL used ?
     */
    protected bool $with_default = true;
    /**
     * User provided attributes for the IMG tag
     */
    protected array $params = [];

    // Srcset & sizes in <img>
    protected bool $responsive = true;

    /**
     * Default image size (base on conventions set up in
     * config/mediaclass.php: xs, sm, md, xl
     */
    protected string $size;
    protected string $default_size = 'sm';

    public function __construct(public Parser $media)
    {
        $this->default_img = Config::defaultImgUrl();
        $this->size = $this->default_size;
    }

    /**
     * Print url
     */
    public function url(string $size = 'sm'): string
    {
        if ($size && $size != $this->default_size) {
            $this->setSize($size);
        }
        return $this->media->urls[$this->size] ?? ($this->media->url ?? ($this->with_default === true ? $this->default_img : ''));
    }

    /**
     * Print image
     */
    public function img(string $size = 'sm'): string
    {
        if ($size && $size != $this->default_size) {
            $this->setSize($size);
        }
        $url = $this->url();
        if ($url) {
            return '<img src="' . $url . '" ' . $this->renderParams() . '/>';
        }
        return '';
    }


    /**
     * Sets the size of the image based on the provided input, according to
     * conventions set up in config/mediaclass.php (xs,sm,md,lg)
     *
     * @param string $size The size of the image. Default is 'sm'.
     * @return static The current instance of the class for method chaining.
     */
    public function setSize(string $size = 'sm'): static
    {
        $this->size = $size;
        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function disableResponsive(): self
    {
        $this->responsive = false;
        return $this;
    }

    /**
     * Disables the return of a default image url
     *
     * @return static The current instance of the class for method chaining.
     */
    public function noDefault(): static
    {
        $this->with_default = false;
        return $this;
    }

    /**
     * Sets a custom parameter for the image instance to be returned in the img tag.
     * ex class => someClass
     * @param array|string $key The parameter key.
     * @param string|null $value The parameter value.
     * @return static The current instance of the class for method chaining.
     */
    public function setParams(array|string $key, ?string $value = null, bool $reset = false): static
    {
        if ($reset) {
            $this->params = [];
        }

        if (!is_array($key)) {
            $this->params[$key] = $value;
            return $this;
        }

        foreach ($key as $arrayKey => $arrayValue) {
            $this->params[$arrayKey] = $arrayValue;
        }

        return $this;
    }

    private function renderParams(): string
    {
        $html = '';

        if (!array_key_exists('alt', $this->params)) {
            $this->params['alt'] = $this->media->description ?: config('app.name');
        }

        if ($this->responsive === true) {

            $srcset = $this->srcSet();

            if ($srcset) {
                $this->params['srcset'] = implode(', ', $srcset['srcset']);
                $this->params['sizes'] = implode(', ', array_reverse($srcset['sizes']));
            }
        }

        foreach ($this->params as $key => $value) {
            $html .= $key . '="' . $value . '" ';
        }

        return $html;
    }

    private function srcSet(): array
    {
        $data = [];
        $sizes = Config::getSizes();

        $maxSize = Config::getMaxSize();

        if ($this->media->urls) {
            foreach ($this->media->urls as $key => $url) {
                $w = $sizes[$key]['width'];
                $data['srcset'][] = $url . ' ' . $w . 'w';
                $data['sizes'][] = $w != $maxSize
                    ? '(max-width:' . $w . 'px' . ') ' . $w . 'px'
                    : $maxSize . 'px';
            }
        }

        return $data;
    }


}
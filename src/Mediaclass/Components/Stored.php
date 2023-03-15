<?php

namespace MetaFramework\Mediaclass\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use MetaFramework\Mediaclass\Models\Mediaclass;

class Stored extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Collection $medias,
        public bool       $positions = false,
        public int|bool   $description = true
    )
    {
        $this->description = $this->description ? 1 : 0;
    }

    public function isFile(Mediaclass $media): bool
    {
        return !str_contains($media->mime, 'image');
    }

    public function isImage(Mediaclass $media): bool
    {
        return str_contains($media->mime, 'image');
    }

    public function render(): Renderable
    {
        return view('mediaclass::components.stored');
    }
}

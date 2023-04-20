<?php

namespace MetaFramework\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OnlineStatus
{

    public function isActive(string $tag = ''): string
    {
        $allowed_tags = ['div', 'td', 'th'];
        $tag = in_array($tag, $allowed_tags) ? $tag : 'span';

        return "<" . $tag . " class='mfw-status " . $this->statusTag() . "'>" . trans('ui.' . ($this->published ? 'yes' : 'no')) . "</" . $tag . ">";
    }

    public function printStatusAsBadge(string $class = 'float-end'): string
    {
        return '<div id="mfw-published_status" data-ajax-url="' . route('mfw.ajax') . '" data-status="' . $this->statusTag() . '" data-id="' . $this->id . '" data-class="' . get_class($this) . '" class="' . $class . ' bg-' . $this->statusClass() . '"><button type="button" class="btn btn-sm btn-'.$this->statusClass().'">' . $this->statusLabel() . '</button></div>';
    }

    public function statusClass(): string
    {
        return (empty($this->published) ? 'danger' : 'success');
    }

    public function statusLabel(): string
    {
        return trans('mfw.published.' . $this->statusTag());
    }

    public function statusTag(): string
    {
        return (empty($this->published) ? 'offline' : 'online');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', 1);
    }

    public function isPublished(): bool
    {
        return (bool)$this->published;
    }
}

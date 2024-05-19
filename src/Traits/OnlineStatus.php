<?php

namespace Aboleon\MetaFramework\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait OnlineStatus
{

    public function isActive(string $tag = ''): string
    {
        $allowed_tags = ['div', 'td', 'th'];
        $tag = in_array($tag, $allowed_tags) ? $tag : 'span';

        return "<" . $tag . " class='aboleon-framework-status " . $this->statusTag() . "'>" .
            ($this->published instanceof Carbon
            ? ($this->published?->format('d/m/Y H:i')  ?: trans('aboleon-framework.no'))
            : ($this->published ? trans('aboleon-framework.yes') : trans('aboleon-framework.no'))) . "</" . $tag . ">";
    }

    public function printStatusAsBadge(): string
    {
        return '<div class="aboleon-framework-published_status" data-ajax-url="' . route('aboleon-framework.ajax') . '" data-status="' . $this->statusTag() . '" data-id="' . $this->id . '" data-class="' . get_class($this) . '" data-label-pushonline="'.__('aboleon-framework.published.publish').'" data-label-pushoffline="'.__('aboleon-framework.published.unpublish').'" data-label-isonline="'.__('aboleon-framework.published.online').'" data-label-isoffline="'.__('aboleon-framework.published.offline').'"><button type="button" class="btn btn-sm btn-'.$this->statusClass().'">' . $this->statusLabel() . '</button></div>';
    }

    public function statusClass(): string
    {
        return (empty($this->published) ? 'danger' : 'success');
    }

    public function statusLabel(): string
    {
        return trans('aboleon-framework.published.' . $this->statusTag());
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

<?php

namespace MetaFramework\Models;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'meta_forms';

    public static function selectables(): array
    {
        $forms = [];
        $data = collect(config('forms'))->pluck('name')->toArray();

        foreach($data as $item) {
            $forms[$item] = __('forms.labels.'.$item);
        }
        return $forms;

    }
}

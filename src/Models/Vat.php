<?php

namespace MetaFramework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property int $rate
 * @property int $id
 * @property bool $default
 */
class Vat extends Model
{

    public $timestamps = false;
    protected $table = 'vat';
    protected $fillable = [
        'rate',
        'default'
    ];

    public function manageDefaultState(): void
    {
        if ($this->default == 1) {
            Vat::query()->where('id', '!=', $this->id)->update(['default' => null]);
            Cache::forget('default_vat_rate');
        }
    }
}

<?php

namespace MetaFramework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
            Vat::where('id', '!=', $this->id)->update(['default' => null]);
            Cache::forget('default_vat_rate');
        }
    }
}

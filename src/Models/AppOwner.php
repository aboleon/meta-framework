<?php

namespace Aboleon\MetaFramework\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|null $address
 */
class AppOwner extends Model
{
    public $timestamps = false;
    protected $table = 'app_owner';
    protected $guarded = [];

    protected $casts = [
      'address' => 'json'
    ];
}

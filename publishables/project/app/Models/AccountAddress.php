<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MetaFramework\Interfaces\GooglePlacesInterface;

class AccountAddress extends Model implements GooglePlacesInterface
{

    protected $guarded = [];

    protected $table = 'account_address';

}

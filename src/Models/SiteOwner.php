<?php

namespace MetaFramework\Models;

use Illuminate\Database\Eloquent\Model;

class SiteOwner extends Model
{
    public $timestamps = false;
    protected $table = 'site_owner';
    protected $guarded = [];
}

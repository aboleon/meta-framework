<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use MetaFramework\Traits\Responses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Throwable;

/**
 * @property string $account_type
 */

class AccountProfile extends Model
{
    use Responses;

    public $timestamps = false;

    protected $table = 'account_profile';

    protected $casts = [
        'birth' => 'date',
        'blacklisted' => 'date'
    ];

    protected $fillable = [
        'rpps',
        'account_type',
        'civ',
        'birth',
        'blacklisted',
        'created_by',
        'blacklist_comment',
        'notes'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withoutGlobalScope('active');
    }

    public function address(): HasMany
    {
        return $this->hasMany(AccountAddress::class, 'user_id');
    }

}

<?php

namespace App\Models;

use App\Interfaces\CreatorInterface;
use App\Traits\{
    DateManipulator,
    Locale,
    ModelObject,
    Users
};
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    BelongsToMany,
    HasOne,
    HasMany};
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use MetaFramework\Mediaclass\Traits\Mediaclass;

/**
 * @property string $type
 * @property AccountProfile|null $profile
 * @property \Illuminate\Database\Eloquent\Collection $address
 * @property \Illuminate\Database\Eloquent\Collection $groups
 */
class Account extends Model implements CreatorInterface, MediaclassInterface
{
    use DateManipulator;
    use Locale;
    use Mediaclass;
    use SoftDeletes;
    use Users;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('userOfTypeAccount', function ($query) {
            $query->where('type', 'account');
        });
    }

    public function getDefaultPhoneNumberAttribute(): string
    {
        // Check if there's a phone set as default.
        $defaultPhone = $this->phones->where('default', 1)->first();

        // If no phone is set as default, get the first available phone.
        if ($defaultPhone === null) {
            $defaultPhone = $this->phones->first();
        }

        // Return the phone object, or null if no phone is found.
        return $defaultPhone?->phone?->formatInternational() ?: 'NC';
    }

    public function getCompanyAttribute(): string
    {
        // Check if there's a phone set as default.
        $billingAddress = $this->address->where('billing', 1)->first();

        // If no phone is set as default, get the first available phone.
        if (empty($billingAddress?->company)) {
            $billingAddress = $this->address->first();
        }

        // Return the phone object, or null if no phone is found.
        return $billingAddress?->company ?: 'NC';
    }

    public function profile(): HasOne
    {
        return $this->hasOne(AccountProfile::class, 'user_id');
    }

    public function address(): HasMany
    {
        return $this->hasMany(AccountAddress::class, 'user_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(AccountPhone::class, 'user_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(AccountDocument::class, 'user_id');
    }

    public function mails(): HasMany
    {
        return $this->hasMany(AccountMail::class, 'user_id');
    }


    public function photoMediaSettings(): array
    {
        return [];
    }
}

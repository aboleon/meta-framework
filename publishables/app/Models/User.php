<?php

namespace App\Models;

use Aboleon\MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use Aboleon\MetaFramework\Mediaclass\Traits\Mediaclass;
use App\Traits\Users;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MediaclassInterface
{

    use Mediaclass;
    use Notifiable;
    use Users;
    use SoftDeletes;

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
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime'
    ];

    public function processRoles(): static
    {
        if ($this->roles->isNotEmpty()) {
            $this->roles->each(function ($item) {
                UserRole::where(['user_id' => $this->id, 'role_id' => $item->role_id])->delete();
            });
        }
        if (request()->filled('roles')) {
            $roles = [];
            foreach (request('roles') as $role) {
                $roles[] = new UserRole(['role_id' => $role]);
            }
            $this->roles()->saveMany($roles);
        }

        return $this;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    public function getRoleAttribute(): ?int
    {
        return $this->userRole();
    }


    public function userSubData(?string $role = null): UserCustomDataInterface|bool
    {
        if (!$role) {
            return false;
        }

        $subclass = "\App\Models\User\\" . ucfirst(Str::camel($role));

        return class_exists($subclass) ? new $subclass : false;
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }


}

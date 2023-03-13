<?php

namespace MetaFramework\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    private array $target_role;
    private array $user_types;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('metaframework.tables.user');
        $this->user_types = config('metawramework-users');
    }


    public function scopeWithRole($query, string|array|null $role = null)
    {
        if ($role) {

            if (is_string($role)) {
                $this->target_role[] = $role;
            } else {
                $this->target_role = $role;
            }

            $roles = collect($this->user_types)->filter(function ($item, $key) {
                return in_array($key, $this->target_role);
            })->pluck('id')->toArray();

            $query->whereHas('roles', function (Builder $subQuery) use ($roles) {
                $subQuery->whereIn('role_id', $roles);
            });
        }
    }

    public function names(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function roles(): HasMany
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    public function userRolesKeys(): array
    {
        return $this->roles->pluck('role_id')->toArray();
    }

    public function hasRole(string|array $role, bool $test = false): bool
    {
        if (!$role) {
            return false;
        }

        if (is_string($role)) {
            $separator = str_contains($role, '|') ? '|' : ',';
            $this->target_role = array_map(fn($x) => trim(str_replace(["'", '"', '[', ']'], '', $x)), explode($separator, $role));
        } else {
            $this->target_role = $role;
        }

        $stringables = collect($this->user_types)->filter(function ($item, $key) {
            return in_array($key, $this->target_role);
        })->pluck('id')->toArray();
        $numerics = collect($this->target_role)->reject(fn($item) => !is_numeric($item))->toArray();
        $targeted = array_unique(array_merge($stringables, $numerics));

        if ($test) {
            d($this->target_role, 'Parsed roles from input');
            d($stringables, 'Stringables');
            d($numerics, 'Numerics');
            d($targeted, 'Targeted');
            d($this->userRolesKeys(), 'User Roles');
            d(array_intersect($targeted, $this->userRolesKeys()), 'CUT');
        }

        return (bool)array_intersect($targeted, $this->userRolesKeys());
    }

    public function userRole(): ?int
    {
        return $this->roles->first()?->role_id;
    }

    public function belongsToSubgroup(string|array $group): bool
    {
        return $this->userTypeParser('subgroup', $group);
    }

    public function belongsToProfile(string|array $profile): bool
    {
        return $this->userTypeParser('profile', $profile);
    }


    private function userTypeParser(string $parser, string|array $group): bool
    {
        if (is_string($group)) {
            $collection = collect($this->user_types)->where($parser, '=', $group)->keys()->toArray();
        } else {
            $collection = collect($this->user_types)->whereIn($parser, $group)->keys()->toArray();
        }
        return $this->hasRole($collection);
    }

}

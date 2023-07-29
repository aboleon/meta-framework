<?php

namespace App\Accessors;

use App\Models\Account;
use App\Models\AccountAddress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class Accounts
{
    public function __construct(public Account $account)
    {
    }

    public static function searchByKeyword(string $keyword): array
    {
        return Account::query()
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.id', 'b.locality', 'c.name->' . app()->getLocale() . ' as country', 'd.account_type', 'd.function')
            ->join('account_address as b', fn($join) => $join->on('users.id', '=', 'b.user_id')->orderBy('billing', 'desc')->take(1)
                ->join('countries as c', 'c.code', '=', 'b.country_code')
            )
            ->join('account_profile as d', 'd.user_id', '=', 'users.id')
            ->where(fn($query) => $query->where('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . Str::slug($keyword) . '%')
            )
            ->groupBy('users.id')
            ->get()
            ->toArray();
    }
    public function isCompany(): bool
    {
        return $this->account->profile?->account_type == 'company';
    }

    public function hasAddressInFrance(): bool
    {
        if ($this->account->address->isEmpty()) {
            return false;
        }
        return (bool)$this->account->address->where('country_code', 'FR')->count();
    }

    public function billingAddress(): ?AccountAddress
    {
        if ($this->account->address->isEmpty()) {
            return null;
        }
        return $this->account->address->filter(fn($item) => !is_null($item->billing))->first();
    }

    public static function getContactsFromPool(array $ids): Collection
    {
        return Account::query()
            ->whereIn('users.id', $ids)
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.id', 'd.account_type', 'd.function')
            ->join('account_profile as d', 'd.user_id', '=', 'users.id')
            ->with('address')
            ->get();
    }
}

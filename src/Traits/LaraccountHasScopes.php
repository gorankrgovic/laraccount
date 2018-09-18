<?php
namespace Laraccount\Traits;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

trait LaraccountHasScopes
{
    /**
     * This scope allows to retrieve the users with a specific account.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $account
     * @param  string  $boolean
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereAccountIs($query, $account = '', $boolean = 'and')
    {
        $method = $boolean == 'and' ? 'whereHas' : 'orWhereHas';
        return $query->$method('accounts', function ($accountQuery) use ($account) {
            $accountQuery->where('name', $account);
        });
    }



    /**
     * This scope allows to retrieve the users with a specific account.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $account
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrWhereAccountIs($query, $account = '')
    {
        return $this->scopeWhereAccountIs($query, $account, 'or');
    }
}

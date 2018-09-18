<?php
namespace Laraccount\Checkers\User;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laraccount\Helper;

/**
 * Created by PhpStorm.
 * User: gorankrgovic
 * Date: 9/17/18
 * Time: 5:08 PM
 */

class LaraccountUserDefaultChecker extends LaraccountUserChecker
{
    /**
     * Checks if the user has a account by its name.
     *
     * @param  string|array  $name       Account name or array of account names.
     * @param  bool          $requireAll All accounts in the array are required.
     * @return bool
     */
    public function currentUserHasAccount($name, $requireAll = false)
    {
        $name = Helper::standardize($name);

        if (is_array($name)) {
            if (empty($name)) {
                return true;
            }
            foreach ($name as $roleName) {
                $hasRole = $this->currentUserHasAccount($roleName);
                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        }
        foreach ($this->userCachedAccounts() as $account) {
            if ($account['name'] == $name) {
                return true;
            }
        }
        return false;
    }


    public function currentUserFlushCache()
    {
        Cache::forget('laraccount_accounts_for_user_' . $this->user->getKey());
    }


    /**
     * Tries to return all the cached roles of the user.
     * If it can't bring the roles from the cache,
     * it brings them back from the DB.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function userCachedAccounts()
    {
        $cacheKey = 'laraccount_accounts_for_user_' . $this->user->getKey();
        if (!Config::get('laraccount.use_cache')) {
            return $this->user->accounts()->get();
        }
        return Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            return $this->user->accounts()->get()->toArray();
        });
    }





}

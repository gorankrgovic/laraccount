<?php
namespace Laraccount\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Laraccount\Checkers\LaraccountCheckerManager;
use Laraccount\Helper;
use InvalidArgumentException;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


trait LaraccountUserTrait
{
    use LaraccountHasEvents;
    use LaraccountHasScopes;

    /**
     * Boots the user model and attaches event listener to
     * remove the many-to-many records when trying to delete.
     * Will NOT delete any records if the user model uses soft deletes.
     *
     * @return void|bool
     */
    public static function bootLaratrustUserTrait()
    {
        $flushCache = function ($user) {
            $user->flushCache();
        };
        // If the user doesn't use SoftDeletes.
        if (method_exists(static::class, 'restored')) {
            static::restored($flushCache);
        }
        static::deleted($flushCache);
        static::saved($flushCache);
        static::deleting(function ($user) {
            if (method_exists($user, 'bootSoftDeletes') && !$user->forceDeleting) {
                return;
            }
            $user->accounts()->sync([]);
        });
    }

    /**
     * Many-to-Many relations with Accunt.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function roles()
    {
        $accounts = $this->morphToMany(
            Config::get('laraccount.models.account'),
            'user',
            Config::get('laraccount.tables.account_user'),
            Config::get('laraccount.foreign_keys.user'),
            Config::get('laraccount.foreign_keys.account')
        );
        return $accounts;
    }


    /**
     * Return the right checker for the user model.
     *
     * @return \Laraccount\Checkers\User\LaraccountUserChecker
     */
    protected function laraccountUserChecker()
    {
        return (new LaraccountCheckerManager($this))->getUserChecker();
    }


    /**
     * Checks if the user has a account by its name.
     *
     * @param  string|array  $name       Account name or array of account names.
     * @param  bool          $requireAll All accounts in the array are required.
     * @return bool
     */
    public function hasAccount($name, $requireAll = false)
    {
        return $this->laraccountUserChecker()->currentUserHasAccount(
            $name,
            $requireAll
        );
    }


    /**
     * Checks if the user has a account by its name.
     *
     * @param  string|array  $account       Account name or array of account names.
     * @param  bool          $requireAll All accounts in the array are required.
     * @return bool
     */
    public function inA($account, $requireAll = false)
    {
        return $this->hasAccount($account, $requireAll);
    }



    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param  string  $relationship
     * @param  mixed  $object
     * @return static
     */
    private function attachLaraccountModel($relationship, $object)
    {
        if (!Helper::isValidRelationship($relationship)) {
            throw new InvalidArgumentException;
        }
        $attributes = [];
        $objectType = Str::singular($relationship);
        $object = Helper::getIdFor($object, $objectType);

        $this->$relationship()->attach(
            $object,
            $attributes
        );
        $this->flushCache();
        $this->fireLaraccountEvent("{$objectType}.attached", [$this, $object]);
        return $this;
    }


    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param  string  $relationship
     * @param  mixed  $object
     * @return static
     */
    private function detachLaraccountModel($relationship, $object)
    {
        if (!Helper::isValidRelationship($relationship)) {
            throw new InvalidArgumentException;
        }
        $objectType = Str::singular($relationship);
        $relationshipQuery = $this->$relationship();
        $object = Helper::getIdFor($object, $objectType);
        $relationshipQuery->detach($object);
        $this->flushCache();
        $this->fireLaraccountEvent("{$objectType}.detached", [$this, $object]);
        return $this;
    }


    /**
     * Alias to eloquent many-to-many relation's sync() method.
     *
     * @param  string  $relationship
     * @param  mixed  $objects
     * @param  boolean  $detaching
     * @return static
     */
    private function syncLaraccountModels($relationship, $objects, $detaching)
    {
        if (!Helper::isValidRelationship($relationship)) {
            throw new InvalidArgumentException;
        }
        $objectType = Str::singular($relationship);
        $mappedObjects = [];

        foreach ($objects as $object) {
            $mappedObjects[] = Helper::getIdFor($object, $objectType);
        }
        $relationshipToSync = $this->$relationship();
        $result = $relationshipToSync->sync($mappedObjects, $detaching);
        $this->flushCache();
        $this->fireLaraccountEvent("{$objectType}.synced", [$this, $result]);
        return $this;
    }


    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param  mixed  $account
     * @return static
     */
    public function attachAccount($account)
    {
        return $this->attachLaraccountModel('accounts', $account);
    }


    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param $account
     * @return static
     */
    public function detachAccount($account)
    {
        return $this->detachLaraccountModel('accounts', $account);
    }


    /**
     * Attach accounts
     *
     * @param array $accounts
     * @return $this
     */
    public function attachAccounts($accounts = [])
    {
        foreach ($accounts as $account) {
            $this->attachAccount($account);
        }
        return $this;
    }


    /**
     * Detach accounts
     *
     * @param array $accounts
     * @return $this
     */
    public function detachAccounts($accounts = [])
    {
        if (empty($accounts)) {
            $accounts = $this->accounts()->get();
        }

        foreach ($accounts as $account) {
            $this->detachAccount($account);
        }
        return $this;
    }

    /**
     * @param array $accounts
     * @param bool $detaching
     * @return mixed
     */
    public function syncAccounts($accounts = [], $detaching = true)
    {
        return $this->syncLaraccountModels('accounts', $accounts, $detaching);
    }


    /**
     * @return mixed
     */
    public function flushCache()
    {
        return $this->laraccountUserChecker()->currentUserFlushCache();
    }

}

<?php
namespace Laraccount\Traits;

use Illuminate\Support\Facades\Config;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


trait LaraccountAccountTrait
{
    use LaraccountDynamicUserRelations;
    use LaraccountHasEvents;


    /**
     * Boots the  model and attaches event listener to
     * remove the many-to-many records when trying to delete.
     * Will NOT delete any records if the model uses soft deletes.
     *
     * @return void|bool
     */
    public static function bootLaraccountAccountTrait()
    {
        static::deleting(function( $account ) {
            if ( method_exists($account, 'bootSoftDeletes') && !$account->forceDeleting ) {
                return;
            }
            foreach( array_keys(Config::get('laraccount.user_models')) as $key ) {
                $account->$key()->sync([]);
            }
        });
    }


    /**
     * Morph by Many relationship between the account and the one of the possible user models
     *
     * @param $relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function getMorphByUserRelation($relationship)
    {
        return $this->morphedByMany(
            Config::get('laraccount.user_models')[$relationship],
            'user',
            Config::get('laraccount.foreign_keys.account'),
            Config::get('laraccount.foreign_keys.user')
        );
    }
}

<?php

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Use MorphMap in relationships between models
    |--------------------------------------------------------------------------
    |
    | If true, the morphMap feature is going to be used. The array values that
    | are going to be used are the ones inside the 'user_models' array.
    |
    */
    'use_morph_map' => false,


    /*
    |--------------------------------------------------------------------------
    | Which account checker to use.
    |--------------------------------------------------------------------------
    |
    | Defines if you want to use the account checker. Available : default, query
    | - default: Check for the accounts using the method that Laraccount
                 has always used.
    | - query: Check for the accounts using direct queries to the database.
    |
     */
    'checker' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Use cache in the package
    |--------------------------------------------------------------------------
    |
    | Defines if Laraccount will use Laravel's Cache to cache the accounts.
    |
    */
    'use_cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Laraccount User Models
    |--------------------------------------------------------------------------
    |
    | This is the array that contains the information of the user models.
    | This information is used in the add-trait command, and for the roles and
    | permissions relationships with the possible user models.
    |
    | The key in the array is the name of the relationship inside the accounts.
    |
    */
    'user_models' => [
        'users' => 'App\User',
    ],


    /*
    |--------------------------------------------------------------------------
    | Laraccount Models
    |--------------------------------------------------------------------------
    |
    | These are the models used by Laraccount to define the accounts.
    | If you want the Laraccount models to be in a different namespace or
    | to have a different name, you can do it here.
    |
    */
    'models' => [
        /**
         * Account model
         */
        'account' => 'App\Account'
    ],


    /*
    |--------------------------------------------------------------------------
    | Laraccount Tables
    |--------------------------------------------------------------------------
    |
    | These are the tables used by Laraccount to store all the authorization data.
    |
    */
    'tables' => [
        /**
         * Accounts table.
         */
        'accounts' => 'accounts',
        /**
         * Account - User intermediate table.
         */
        'account_user' => 'account_user'
    ],


    /*
    |--------------------------------------------------------------------------
    | Laraccount Foreign Keys
    |--------------------------------------------------------------------------
    |
    | These are the foreign keys used by laraccount in the intermediate tables.
    |
    */
    'foreign_keys' => [
        /**
         * User foreign key on Laraccount's account_user table.
         */
        'user' => 'user_id',
        /**
         * Account foreign key on Laraccount's account_user table.
         */
        'account' => 'account_id'
    ],

];

<?php
namespace Laraccount;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


class Laraccount
{

    /**
     * Laravel application.
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }


    /**
     * Checks if the current user has an account by its name.
     *
     * @param string $account Account name
     * @param bool $requireAll
     * @return bool
     */
    public function hasAccount($account, $requireAll = false)
    {
        if ( $user = $this->user() )
        {
            return $user->hasAccount($account, $requireAll);
        }

        return false;
    }



    /**
     * Get the currently authenticated user or null.
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function user()
    {
        return $this->app->auth->user();
    }

}

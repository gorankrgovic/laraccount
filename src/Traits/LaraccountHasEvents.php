<?php
namespace Laraccount\Traits;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

trait LaraccountHasEvents
{

    /**
     * Register an observer to the events.
     *
     * @param  object|string  $class
     * @return void
     */
    public static function laraccountObserve($class)
    {
        $observables = [
            'accountAttached',
            'accountDetached',
            'accountSynced'
        ];
        $className = is_string($class) ? $class : get_class($class);
        foreach ($observables as $event) {
            if (method_exists($class, $event)) {
                static::registerLaraccountEvent(\Illuminate\Support\Str::snake($event, '.'), $className.'@'.$event);
            }
        }
    }



    /**
     * Fire the given event for the model.
     *
     * @param  string  $event
     * @param  array  $payload
     * @return mixed
     */
    protected function fireLaraccountEvent($event, array $payload)
    {
        if (! isset(static::$dispatcher)) {
            return true;
        }
        return static::$dispatcher->fire(
            "laraccount.{$event}: ".static::class,
            $payload
        );
    }

    /**
     * Register a laraccount event with the dispatcher.
     *
     * @param  string  $event
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function registerLaraccountEvent($event, $callback)
    {
        if (isset(static::$dispatcher)) {
            $name = static::class;
            static::$dispatcher->listen("laraccount.{$event}: {$name}", $callback);
        }
    }

    /**
     * Register a account attached laraccount event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function accountAttached($callback)
    {
        static::registerLaraccountEvent('account.attached', $callback);
    }



    /**
     * Register a account detached laraccount event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function accountDetached($callback)
    {
        static::registerLaraccountEvent('account.detached', $callback);
    }



    /**
     * Register a account synced laraccount event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function accountSynced($callback)
    {
        static::registerLaraccountEvent('account.synced', $callback);
    }


}

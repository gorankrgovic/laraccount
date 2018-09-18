<?php
namespace Laraccount;

use Illuminate\Support\Facades\Facade;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

class LaraccountFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraccount';
    }
}

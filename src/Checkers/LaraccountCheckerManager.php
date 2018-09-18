<?php
namespace Laraccount\Checkers;

use Illuminate\Support\Facades\Config;
use Laraccount\Checkers\User\LaraccountUserDefaultChecker;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


class LaraccountCheckerManager
{

    /**
     * The object
     *
     * @var \Illuminate\\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getUserChecker()
    {
        switch (Config::get('laraccount.checker', 'default')) {
            case 'default':
                return new LaraccountUserDefaultChecker($this->model);
            case 'query':
                return;
        }
    }
}

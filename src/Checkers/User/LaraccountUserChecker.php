<?php
namespace Laraccount\Checkers\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: gorankrgovic
 * Date: 9/17/18
 * Time: 5:09 PM
 */


abstract class LaraccountUserChecker
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $user;


    public function __construct(Model $user)
    {
        $this->user = $user;
    }

    abstract public function currentUserHasAccount($name, $requireAll = false);
    abstract public function currentUserFlushCache();
}

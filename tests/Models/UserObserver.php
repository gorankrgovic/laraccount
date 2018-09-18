<?php
namespace Laraccount\Tests\Models;

class UserObserver
{
    public function accountAttached($user, $thing)
    {
    }
    public function accountDetached($user, $thing)
    {
    }
    public function accountSynced($user, $thing)
    {
    }
}

<?php
namespace Laraccount\Test;

use Laraccount\Tests\LaraccountTestCase;
use Laraccount\Tests\Models\Account;

/**
 * Created by PhpStorm.
 * User: gorankrgovic
 * Date: 9/18/18
 * Time: 10:44 AM
 */

class LaraccountAccountTest extends LaraccountTestCase
{
    protected $account;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->account = Account::create(['name' => 'account']);
    }


    public function testUsersRelationship()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphToMany', $this->account->users());
    }

    public function testAccessUsersRelationshipAsAttribute()
    {
        $this->assertEmpty($this->account->users);
    }

}

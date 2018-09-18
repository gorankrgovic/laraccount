<?php
namespace Laraccount\Test;

use Laraccount\Tests\Models\Account;
use Mockery as m;
use Laraccount\Tests\LaraccountTestCase;



class LaraccountUserTest extends LaraccountTestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->user = User::create(['name' => 'test', 'email' => 'test@test.com']);
    }

    public function testAccountsRelationship()
    {
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\MorphToMany',
            $this->user->accounts()
        );
    }


    public function testAttachAccount()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $account = Account::create(['name' => 'account_a']);
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        // Can attach account by passing an object
        $this->assertWasAttached('account', $this->user->attachAccount($account));
        // Can attach account by passing an id
        $this->assertWasAttached('account', $this->user->attachAccount($account->id));
        // Can attach account by passing an array with 'id' => $id
        $this->assertWasAttached('account', $this->user->attachAccount($account->toArray()));
        // Can attach account by passing the name
        $this->assertWasAttached('account', $this->user->attachAccount('account_a'));
        $this->assertInstanceOf('Laraccount\Tests\Models\User', $this->user->attachAccount($account));
    }


    public function testDetachAccount()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $account = Account::create(['name' => 'account_a']);
        $this->user->accounts()->attach($account->id);
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $this->assertWasDetached('account', $this->user->detachAccount($account), $account);
        $this->assertWasDetached('account', $this->user->detachAccount($account->id), $account);
        $this->assertWasDetached('account', $this->user->deatchAccount($account->toArray()), $account);
        $this->assertInstanceOf('Laraccount\Tests\Models\User', $this->user->detachAccount('account_a'));
        $this->assertEquals(0, $this->user->accounts()->count());
    }


    protected function assertWasAttached($objectName, $result)
    {
        $relationship = \Illuminate\Support\Str::plural($objectName);
        $this->assertInstanceOf('Laraccount\Tests\Models\User', $result);
        $this->assertEquals(1, $this->user->$relationship()->count());
        $this->user->$relationship()->sync([]);
    }
    protected function assertWasDetached($objectName, $result, $toReAttach)
    {
        $relationship = \Illuminate\Support\Str::plural($objectName);
        $this->assertInstanceOf('Laraccount\Tests\Models\User', $result);
        $this->assertEquals(0, $this->user->$relationship()->count());
        $this->user->$relationship()->attach($toReAttach->id);
    }



}

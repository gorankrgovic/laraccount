<?php
namespace Laraccount\Test;

use Laraccount\Tests\LaraccountTestCase;
use Laraccount\Tests\Models\Account;
use Laraccount\Tests\Models\User;

class LaraccountUserScopesTest extends LaraccountTestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->user = User::create(['name' => 'test', 'email' => 'test@test.com']);
    }

    public function testScopeWhereAccountIs()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
         */
        $accountA = Account::create(['name' => 'account_a']);
        $accountC = Account::create(['name' => 'account_c']);
        $this->user->attachAccount($accountA);
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
         */
        $this->assertCount(1, User::whereAccountIs('account_a')->get());
        $this->assertCount(0, User::whereAccountIs('account_c')->get());
    }

    public function testScopeOrWhereAccountIs()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
         */
        $accountA = Account::create(['name' => 'account_a']);
        $accountC = Account::create(['name' => 'account_c']);
        $this->user->attachAccount($accountA);
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
         */
        $this->assertCount(
            1,
            User::query()
                ->whereAccountIs('account_a')
                ->orWhereAccountIs('account_c')
                ->get()
        );
        $this->assertCount(
            0,
            User::query()
                ->whereAccountIs('account_d')
                ->orWhereAccountIs('account_c')
                ->get()
        );
    }

}

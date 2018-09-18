<?php
namespace Laraccount\Tests;

use Laraccount\Tests\Models\Account;
use Laraccount\Tests\Models\User;


class LaraccountUserEventsTest extends LaraccountEventsTestCase
{

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = User::create(['name' => 'test', 'email' => 'test@test.com']);
    }


    public function testCanListenToTheAccountAttachedEvent()
    {
        $this->listenTo('account.attached', User::class);
        $this->assertHasListenersFor('account.attached', User::class);
    }

    public function testCanListenToTheAccountDetachedEvent()
    {
        $this->listenTo('account.detached', User::class);
        $this->assertHasListenersFor('account.detached', User::class);
    }

    public function testCanListenToTheAccountSyncedEvent()
    {
        $this->listenTo('account.synced', User::class);
        $this->assertHasListenersFor('acount.synced', User::class);
    }

    public function testAnEventIsFiredWhenAccountIsAttachedToUser()
    {
        User::setEventDispatcher($this->dispatcher);
        $account = Account::create(['name' => 'account']);
        $this->dispatcherShouldFire('account.attached', [$this->user, $account->id, null], User::class);
        $this->user->attachAccount($account);
    }

    public function testAnEventIsFiredWhenAccountIsDetachedFromUser()
    {
        $account = Account::create(['name' => 'account']);
        $this->user->attachAccount($account);
        User::setEventDispatcher($this->dispatcher);
        $this->dispatcherShouldFire('account.detached', [$this->user, $account->id, null], User::class);
        $this->user->detachAccount($account);
    }


    public function testAnEventIsFiredWhenAccountsAreSynced()
    {
        $account = Account::create(['name' => 'account']);
        User::setEventDispatcher($this->dispatcher);
        $this->dispatcherShouldFire('account.synced', [
            $this->user,
            [
                'attached' => [$account->id], 'detached' => [], 'updated' => [],
            ],
            null
        ], User::class);
        $this->user->syncAccounts([$account]);
    }


    public function testCanAddObservableClasses()
    {
        $events = [
            'account.attached',
            'account.detached',
            'account.synced'
        ];
        User::laraccountObserve(\Laraccount\Tests\Models\UserObserver::class);
        foreach ($events as $event) {
            $this->assertTrue(User::getEventDispatcher()->hasListeners("laraccount.{$event}: " . User::class));
        }
    }


}

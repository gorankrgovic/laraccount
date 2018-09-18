<?php
use Mockery as m;
use Laraccount\Laraccount;
use Laraccount\Tests\LaraccountTestCase;




class LaraccountTest extends LaraccountTestCase
{

    protected $laraccount;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->laraccount = m::mock('Laraccount\Laraccount[user]', [$this->app]);
        $this->user = m::mock('_mockedUser');
    }


    public function testHasAccount()
    {
        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        $this->laraccount->shouldReceive('user')->andReturn($this->user)->twice()->ordered();
        $this->laraccount->shouldReceive('user')->andReturn(false)->once()->ordered();
        $this->user->shouldReceive('hasAccount')->with('UserAccount')->andReturn(true)->once();
        $this->user->shouldReceive('hasAccount')->with('NonUserAccount')->andReturn(false)->once();
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $this->assertTrue($this->laraccount->hasAccount('UserAccount'));
        $this->assertFalse($this->laraccount->hasAccount('NonUserAccount'));
        $this->assertFalse($this->laraccount->hasAccount('AnyAccount'));
    }


    public function testUser()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $this->laraccount = new Laraccount($this->app);
        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($this->user)->once();
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $this->assertSame($this->user, $this->laraccount->user());
    }


}

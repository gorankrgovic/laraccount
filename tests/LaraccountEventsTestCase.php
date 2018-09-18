<?php
namespace Laraccount\Tests;

use Mockery as m;

class LaraccountEventsTestCase extends LaraccountTestCase
{
    protected $dispatcher;


    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->dispatcher = m::mock('\Illuminate\Events\Dispatcher')->makePartial();
    }


    /**
     * Listen to a Laraccount event.
     *
     * @param  string $event
     * @return void
     */
    protected function listenTo($event, $modelClass)
    {
        $method = \Illuminate\Support\Str::camel(str_replace('.', ' ', $event));
        $modelClass::{$method}(function ($user, $accountId) {
            return 'test';
        });
    }


    /**
     * Assert that the dispatcher has listeners for the given event.
     *
     * @param  string $event
     * @return void
     */
    protected function assertHasListenersFor($event, $modelClass)
    {
        $eventName = "laraccount.{$event}: {$modelClass}";
        $dispatcher = $modelClass::getEventDispatcher();
        $this->assertTrue($dispatcher->hasListeners($eventName));
        $this->assertCount(1, $dispatcher->getListeners($eventName));
        $this->assertEquals('test', $dispatcher->fire($eventName, ['user', 'an_id'])[0]);
    }

    /**
     * Assert the dispatcher fires the fire event with the given data.
     *
     * @param  string $event
     * @param  array  $payload
     * @param  string $modelClass
     * @return void
     */
    protected function dispatcherShouldFire($event, array $payload, $modelClass)
    {
        $this->dispatcher->shouldReceive('fire')
            ->with(
                "laraccount.{$event}: {$modelClass}",
                $payload
            )
            ->andReturn(null)
            ->once()->ordered();
    }






}

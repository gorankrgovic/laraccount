<?php
namespace Laraccount\Tests;


use Orchestra\Testbench\TestCase;

class LaraccountTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [\Laraccount\LaraccountServiceProvider::class];
    }


    protected function getPackageAliases($app)
    {
        return ['Laraccount' => 'Laraccount\LaraccountFacade'];
    }


    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.default', 'array');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('laraccount.user_models.users', 'Laraccount\Tests\Models\User');
        $app['config']->set('laraccount.models', [
            'account' => 'Laraccount\Tests\Models\Account',
        ]);
    }

    public function migrate()
    {
        $migrations = [
            \Laraccount\Tests\Migrations\UsersMigration::class,
            \Laraccount\Tests\Migrations\LaraccountSetupTables::class,
        ];
        foreach ($migrations as $migration) {
            (new $migration)->up();
        }
    }


}

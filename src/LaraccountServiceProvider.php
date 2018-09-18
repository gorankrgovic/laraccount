<?php
namespace Laraccount;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


class LaraccountServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'Migration' => 'command.laraccount.migration',
        'MakeAccount' => 'command.laraccount.account',
        'AddLaraccountUserTrait' => 'command.laraccount.add-trait',
        'Setup' => 'command.laraccount.setup'
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laraccount.php', 'laraccount');

        $this->publishes([
            __DIR__.'/../config/laraccount.php' => config_path('laraccount.php'),
        ], 'laraccount');

        $this->useMorphMapForRelationships();

        if (class_exists('\Blade')) {
            $this->registerBladeDirectives();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLaraccount();
        $this->registerCommands();
    }

    /**
     * If the user wants to use the morphMap it uses the morphMap.
     *
     * @return void
     */
    protected function useMorphMapForRelationships()
    {
        if ($this->app['config']->get('laraccount.use_morph_map')) {
            Relation::morphMap($this->app['config']->get('laraccount.user_models'));
        }
    }

    /**
     * Register the blade directives.
     *
     * @return void
     */
    private function registerBladeDirectives()
    {
        (new LaraccountRegistersBladeDirectives())->handle($this->app->version());
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerLaraccount()
    {
        $this->app->bind('laraccount', function ($app) {
            return new Laraccount($app);
        });
        $this->app->alias('laraccount', 'Laraccount\Laraccount');
    }


    /**
     * Register the given commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        foreach (array_keys($this->commands) as $command) {
            $method = "register{$command}Command";
            call_user_func_array([$this, $method], []);
        }
        $this->commands(array_values($this->commands));
    }

    protected function registerMigrationCommand()
    {
        $this->app->singleton('command.laraccount.migration', function () {
            return new \Laraccount\Commands\MigrationCommand();
        });
    }

    protected function registerMakeAccountCommand()
    {
        $this->app->singleton('command.laraccount.account', function ($app) {
            return new \Laraccount\Commands\MakeAccountCommand($app['files']);
        });
    }

    protected function registerAddLaraccountUserTraitCommand()
    {
        $this->app->singleton('command.laraccount.add-trait', function () {
            return new \Laraccount\Commands\AddLaraccountTraitCommand();
        });
    }

    protected function registerSetupCommand()
    {
        $this->app->singleton('command.laraccount.setup', function () {
            return new \Laraccount\Commands\SetupCommand();
        });
    }


    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }

}

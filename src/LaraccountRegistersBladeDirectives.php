<?php
namespace Laraccount;


use Illuminate\Support\Facades\Blade;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

class LaraccountRegistersBladeDirectives
{
    /**
     * Handles the registration of the blades directives.
     *
     * @param  string  $laravelVersion
     * @return void
     */
    public function handle($laravelVersion = '5.3.0')
    {
        if (version_compare(strtolower($laravelVersion), '5.3.0-dev', '>=')) {
            $this->registerWithParenthesis();
        } else {
            $this->registerWithoutParenthesis();
        }
        $this->registerClosingDirectives();
    }

    /**
     * Registers the directives with parenthesis.
     *
     * @return void
     */
    protected function registerWithParenthesis()
    {
        // Call to Laraccount::hasAccount.
        Blade::directive('account', function ($expression) {
            return "<?php if (app('laraccount')->hasAccount({$expression})) : ?>";
        });
    }


    /**
     * Registers the directives without parenthesis.
     *
     * @return void
     */
    protected function registerWithoutParenthesis()
    {
        // Call to Laraccount::hasAccount.
        Blade::directive('account', function ($expression) {
            return "<?php if (app('laraccount')->hasAccount{$expression}) : ?>";
        });
    }


    /**
     * Registers the closing directives.
     *
     * @return void
     */
    protected function registerClosingDirectives()
    {
        Blade::directive('endaccount', function () {
            return "<?php endif; // app('laraccount')->hasAccount ?>";
        });
    }

}

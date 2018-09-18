<?php
namespace Laraccount\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

class MakeAccountCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laraccount:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Account model if it does not exist';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Account model';



    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__. '/../../stubs/account.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return Config::get('laraccount.models.account', 'Account');
    }



    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

}

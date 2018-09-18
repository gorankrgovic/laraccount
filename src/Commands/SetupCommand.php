<?php
namespace Laraccount\Commands;

use Illuminate\Console\Command;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


class SetupCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laraccount:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup for Laraccount';


    /**
     * Commands to call with their description.
     *
     * @var array
     */
    protected $calls = [
        'laraccount:migration' => 'Creating migration',
        'laraccount:account' => 'Creating Account model',
        'laraccount:add-trait' => 'Adding LaraccountUserTrait to User model'
    ];

    /**
     * Create a new command instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->calls as $command => $info) {
            $this->line(PHP_EOL . $info);
            $this->call($command);
        }
    }

}

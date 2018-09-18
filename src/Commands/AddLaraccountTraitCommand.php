<?php
namespace Laraccount\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Laraccount\Traits\LaraccountUserTrait;
use Traitor\Traitor;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */

class AddLaraccountTraitCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laraccount:add-trait';


    /**
     * Trait added to User model
     *
     * @var string
     */
    protected $targetTrait = LaraccountUserTrait::class;


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $models = $this->getUserModels() ;
        foreach ($models as $model) {
            if (!class_exists($model)) {
                $this->error("Class $model does not exist.");
                return;
            }
            if ($this->alreadyUsesTrait($model)) {
                $this->error("Class $model already uses LaraccountUserTrait.");
                continue;
            }
            Traitor::addTrait($this->targetTrait)->toClass($model);
        }
        $this->info("LaraccountUserTrait added successfully to {$models->implode(', ')}");
    }


    /**
     * @param $model
     * @return bool
     */
    protected function alreadyUsesTrait( $model )
    {
        return in_array(LaraccountUserTrait::class, class_uses($model));
    }

    /**
     * Get the description of which clases the LaratrustUserTrait was added.
     *
     * @return string
     */
    public function getDescription()
    {
        return "Add LaraccountUserTrait to {$this->getUserModels()->implode(', ')} class";
    }

    /**
     * Return the User models array.
     *
     * @return array
     */
    protected function getUserModels()
    {
        return new Collection(Config::get('laraccount.user_models', []));
    }




}

<?php
namespace Laraccount\Models;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Laraccount\Interfaces\LaraccountAccountInterface;
use Laraccount\Traits\LaraccountAccountTrait;


class LaraccountAccount extends Model implements LaraccountAccountInterface
{
    use LaraccountAccountTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('laraccount.tables.accounts');
    }
}

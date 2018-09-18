<?php
namespace Laraccount\Tests\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laraccount\Models\LaraccountAccount;

class Account extends LaraccountAccount
{
    use SoftDeletes;
    protected $guarded = [];
}

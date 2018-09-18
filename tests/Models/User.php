<?php
namespace Laraccount\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraccount\Traits\LaraccountUserTrait;

class User extends Model
{
    use LaraccountUserTrait;
    use SoftDeletes;

    protected $guarded = [];
}

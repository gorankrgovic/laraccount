<?php
namespace Laraccount\Interfaces;

/**
 * Created by PhpStorm.
 * User: gorankrgovic
 * Date: 9/17/18
 * Time: 4:19 PM
 */

interface LaraccountAccountInterface
{
    /**
     * Morph by Many relationship between the account and the one of the possible user models.
     *
     * @param  string  $relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function getMorphByUserRelation($relationship);

}

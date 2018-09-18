<?php
namespace Laraccount;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

/**
 * This file is part of the Laraccount,
 * an account based management solution for Laravel.
 *
 * @license MIT
 * @package Laraccount
 */


class Helper
{
    /**
     * Gets the it from an array, object or integer.
     *
     * @param  mixed  $object
     * @param  string  $type
     * @return int
     */
    public static function getIdFor($object, $type)
    {
        if (is_null($object)) {
            return null;
        } elseif (is_object($object)) {
            return $object->getKey();
        } elseif (is_array($object)) {
            return $object['id'];
        } elseif (is_numeric($object)) {
            return $object;
        } elseif (is_string($object)) {
            return call_user_func_array([
                Config::get("laraccount.models.{$type}"), 'where'
            ], ['name', $object])->firstOrFail()->getKey();
        }
        throw new InvalidArgumentException(
            'getIdFor function only accepts an integer, a Model object or an array with an "id" key'
        );
    }

    /**
     * Check if a string is a valid relationship name.
     *
     * @param string $relationship
     * @return boolean
     */
    public static function isValidRelationship($relationship)
    {
        return in_array($relationship, ['accounts']);
    }

    /**
     * Checks if the string passed contains a pipe '|' and explodes the string to an array.
     * @param  string|array  $value
     * @return string|array
     */
    public static function standardize($value, $toArray = false)
    {
        if (is_array($value) || ((strpos($value, '|') === false) && !$toArray)) {
            return $value;
        }
        return explode('|', $value);
    }

    /**
     * Checks if the option exists inside the array,
     * otherwise, it sets the first option inside the default values array.
     *
     * @param  string  $option
     * @param  array  $array
     * @param  array  $possibleValues
     * @return array
     */
    public static function checkOrSet($option, $array, $possibleValues)
    {
        if (!isset($array[$option])) {
            $array[$option] = $possibleValues[0];
            return $array;
        }
        $ignoredOptions = ['foreignKeyName'];
        if (!in_array($option, $ignoredOptions) && !in_array($array[$option], $possibleValues, true)) {
            throw new InvalidArgumentException();
        }
        return $array;
    }



    /**
     * Creates a model from an array filled with the class data.
     *
     * @param string $class
     * @param string|\Illuminate\Database\Eloquent\Model $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function hidrateModel($class, $data)
    {
        if ($data instanceof Model) {
            return $data;
        }
        if (!isset($data['pivot'])) {
            throw new \Exception("The 'pivot' attribute in the {$class} is hidden");
        }
        $model = new $class;
        $primaryKey = $model->getKeyName();
        $model->setAttribute($primaryKey, $data[$primaryKey])->setAttribute('name', $data['name']);
        $model->setRelation(
            'pivot',
            MorphPivot::fromRawAttributes($model, $data['pivot'], 'pivot_table')
        );
        return $model;
    }





}

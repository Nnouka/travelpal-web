<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 11:03 AM
 */

namespace App\CustomValidators;


class NumberValidator
{
    public static function notNull($field) {
        $validationError = [];
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if ($value == null) {
                    $validationError[$key] = $key.' cannot be null';
                }
            }
        }
        return $validationError;
    }

    public static function lessThan($field, $size = 0) {
        $validationError = [];
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if ($value >= $size ) {
                    $validationError[$key] = $key.' must be less than '.$size;
                }
            }
        }
        return $validationError;
    }
    public static function greaterThan($field, $size = 0) {
        $validationError = [];
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if ($value <= $size) {
                    $validationError[$key] = $key.' must be greater than '.$size;
                }
            }
        }
        return $validationError;
    }
    public static function positive($field) {
        $validationError = [];
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if ($value < 0) {
                    $validationError[$key] = $key.' must be positive';
                }
            }
        }
        return $validationError;
    }

    public static function negative($field) {
        $validationError = [];
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if ($value > 0) {
                    $validationError[$key] = $key.' must be negative';
                }
            }
        }
        return $validationError;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/21/20
 * Time: 3:36 PM
 */

namespace App\CustomValidators;
use App\Exceptions\ApiException;


class StringValidator
{

    public static function notBlank($field) {
        $validationError = [];
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if ($value == null || trim(strval($value)) == '') {
                    $validationError[$key] = $key.' cannot be blank';
                }
            }
        }
        return $validationError;
    }
}
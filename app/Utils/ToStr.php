<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 4:30 AM
 */

namespace App\Utils;


class ToStr
{
    public static function arrayToStr($array) {
        if ($array !== null && is_array($array)) {
            $toString = "{";
            $k = sizeof($array) - 1;
            $i = 0;
            foreach ($array as $key => $value) {
                $toString .= "\"$key\": "."\"$value\"";
                if ($k > $i) {
                    $toString .= ',';
                }
                $i++;
            }
            return $toString."}";
        }
        return null;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/24/20
 * Time: 4:16 PM
 */

namespace App\Utils;


class Base64
{

    public static function encode($text) {
        return base64_encode(strval($text));
    }
    public static function urlEncode($text) {
        return str_replace(['+', '/', '='], ['-', '_', ''], self::encode($text));
    }
    public static function decode($text) {
        return base64_decode(strval($text));
    }

}
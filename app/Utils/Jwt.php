<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/24/20
 * Time: 4:47 PM
 */

namespace App\Utils;


class Jwt
{
    private static $header = [];
    private static $payload = [];
    private static $signature;
    public static $encodedHeader;
    public static $encodedPayload;

    /**
     * @return array
     */
    public static function getHeader()
    {
        return self::$header;
    }

    /**
     * @param array $header
     */
    public static function setHeader($header)
    {
        self::$header = $header;
    }

    /**
     * @return array
     */
    public static function getPayload()
    {
        return self::$payload;
    }

    /**
     * @param array $payload
     */
    public static function setPayload($payload)
    {
        self::$payload = $payload;
    }

    /**
     * @return mixed
     */
    public static function getSignature()
    {
        return self::$signature;
    }

    /**
     * @param mixed $signature
     */
    public static function setSignature($signature)
    {
        self::$signature = $signature;
    }

    /**
     * @return mixed
     */
    public static function getEncodedHeader()
    {
        return self::$encodedHeader;
    }

    /**
     * @param mixed $encodedHeader
     */
    public static function setEncodedHeader($encodedHeader)
    {
        self::$encodedHeader = $encodedHeader;
    }

    /**
     * @return mixed
     */
    public static function getEncodedPayload()
    {
        return self::$encodedPayload;
    }

    /**
     * @param mixed $encodedPayload
     */
    public static function setEncodedPayload($encodedPayload)
    {
        self::$encodedPayload = $encodedPayload;
    }

    public static function setHeaderClaim($claim, $value) {
        self::$header[$claim] = $value;
    }
    public static function setPayloadClaim($claim, $value) {
        self::$payload[$claim] = $value;
    }
    public static function jsonEncode() {
        self::$encodedHeader = json_encode(self::$header);
        self::$encodedPayload = json_encode(self::$payload);
    }
    public static function sign($secret) {
        self::$signature = Base64::urlEncode(hash_hmac('sha256',
            Base64::urlEncode(self::$encodedHeader).".".Base64::urlEncode(self::$encodedPayload),
            Base64::urlEncode($secret), true));
    }
    public static function generate() {
        return Base64::urlEncode(self::$encodedHeader).".".Base64::urlEncode(self::$encodedPayload).".".self::$signature;
    }

}
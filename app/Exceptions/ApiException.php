<?php

namespace App\Exceptions;


use Illuminate\Http\Response;
use App\CustomObjects\HttpStatus;

class ApiException
{
    public static function report($message, $code, $endpoint = '/') {
        $response = self::prepareHeader($code);
        $response->setContent(self::toJson([
            "message" => $message,
            "code" => HttpStatus::$statusTexts[$code],
            "endpoint" => $endpoint
        ]));
        return $response;
    }

    public static function reportValidationError($error, $code, $endpoint = '/') {
        $response = self::prepareHeader($code);
        $response->setContent(self::toJson([
            "message" => "VALIDATION_ERROR",
            "error" => $error,
            "code" => HttpStatus::$statusTexts[$code],
            "endpoint" => $endpoint
        ]));
        return $response;
    }

    public static function prepareHeader($code) {
        $response = new Response();
        $response->header('Content-Type', 'application/json');
        $response->setStatusCode($code);
        return $response;
    }

    public static function toString($message, $code, $endpoint) {
        return "{\"code\": \"".$code."\",\"message\": \"".$message."\","."\"endpoint\": \"".$endpoint."\"}";
    }

    public static function toJson($array) {
        return json_encode($array);
    }

    public static function validationErrorToStr($error, $code, $endpoint, $message = "VALIDATION_ERROR") {
        return "{\"code\": \"".$code."\",\"error\": ".$error.",".
            "\"message\": \"".$message."\",".
            "\"endpoint\": \"".$endpoint."\"}";
    }
}

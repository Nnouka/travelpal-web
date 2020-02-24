<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/24/20
 * Time: 5:15 PM
 */

namespace App\Services;


use App\CustomObjects\Dtos\JwtDto;
use App\Utils\Jwt;

class JwtService
{

    public function generateTest($request) {
        $client = AuthService::get();
        // set type
        Jwt::setHeaderClaim("typ", "JWT");
        // set algorithm
        Jwt::setHeaderClaim("alg", "HS256");
        // set sub
        Jwt::setPayloadClaim("sub", "test@test.com");
        // set roles
        Jwt::setPayloadClaim("rol", ["USER", "ADMIN", "MANAGER"]);
        // set name
        Jwt::setPayloadClaim("nam", "Test User");
        //set issued at
        $iat = new \DateTime();
        Jwt::setPayloadClaim("iat", $iat->getTimestamp());
        // set expires at
        $exp = $iat->getTimestamp() + 36000;
        Jwt::setPayloadClaim("exp", $exp);
        // set audience
        Jwt::setPayloadClaim("aud", "MyApp");
        // set id
        Jwt::setPayloadClaim("uid", 10);
        // encode
        Jwt::jsonEncode();
        // sign
        Jwt::sign($client->app_key);
        return new JwtDto(
            "Authorization",
            "Jwt AuthServer",
            Jwt::generate(),
            "Bearer",
            $exp
        );
    }
}
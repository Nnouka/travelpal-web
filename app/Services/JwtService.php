<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/24/20
 * Time: 5:15 PM
 */

namespace App\Services;


use App\CustomObjects\Dtos\JwtDto;
use App\CustomObjects\HttpStatus;
use App\Exceptions\ApiException;
use App\User;
use App\Utils\Jwt;

class JwtService
{

    public function generateTest() {
        $client = AuthService::get();
        // set type
        Jwt::setHeaderClaim("typ", "JWT");
        // set algorithm
        Jwt::setHeaderClaim("alg", "HS256");
        // set eml
        Jwt::setPayloadClaim("eml", "test@test.com");
        // set roles
        Jwt::setPayloadClaim("rol", ["USER", "ADMIN", "MANAGER"]);
        // set name
        Jwt::setPayloadClaim("nam", "Test User");
        //set issued at
        $iat = new \DateTime();
        Jwt::setPayloadClaim("iat", $iat->getTimestamp());
        // set expires at
        $exp = $iat->getTimestamp() + $client->access_token_validity;
        Jwt::setPayloadClaim("exp", $exp);
        // set audience
        Jwt::setPayloadClaim("aud", $client->name);
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

    public function generate($email, $password, $endpoint = '/') {
        $client = AuthService::get();
        if (AuthService::authUserCheck($email, $password)) {
            $this->prepareHeader();
            $user = AuthService::authUserGet();
            // set eml
            Jwt::setPayloadClaim("eml", $user->email);
            // set roles
            // prepare roles array
            $roles = [];
            foreach ($user->roles()->get() as $key => $role) {
                $roles[$key] = $role->name;
            }
            Jwt::setPayloadClaim("rol", $roles);
            // set name
            Jwt::setPayloadClaim("nam", $user->name);
            //set issued at
            $iat = new \DateTime();
            Jwt::setPayloadClaim("iat", $iat->getTimestamp());
            // set expires at
            $exp = $iat->getTimestamp() + $client->access_token_validity;
            Jwt::setPayloadClaim("exp", $exp);
            // set audience
            Jwt::setPayloadClaim("aud", $client->client_id);
            // set id
            Jwt::setPayloadClaim("uid", $user->id);
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
        } else {
            return ApiException::report("User Credentials do not match", HttpStatus::HTTP_FORBIDDEN, $endpoint);
        }

    }

    public function prepareHeader() {
        // set type
        Jwt::setHeaderClaim("typ", "JWT");
        // set algorithm
        Jwt::setHeaderClaim("alg", "HS256");
    }
}
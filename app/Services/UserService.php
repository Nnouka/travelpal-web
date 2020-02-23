<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 1:23 PM
 */

namespace App\Services;


use App\CustomObjects\Dtos\RegisterUserDto;
use App\CustomObjects\HttpStatus;
use App\Exceptions\ApiException;
use App\User;

class UserService
{
    public function register(RegisterUserDto $userDto) {
        $valid = $userDto->validate();
        if ($valid !== null) {
            return $valid;
        } else if (!$this->validateNewUser($userDto->getEmail())) {
            return ApiException::report("email already in use",
                HttpStatus::HTTP_CONFLICT, $userDto->getEndpoint());
        }

        return User::create([
            "email" => $userDto->getEmail(),
            "password" => $userDto->getEncryptedPassword(),
            "name" => $userDto->getFullName()
        ]);
    }

    public function validateNewUser($email) {
        $u = User::where("email", $email)->get()->first();
        return $u == null;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 1:23 PM
 */

namespace App\Services;


use App\CustomObjects\Dtos\LocationDTO;
use App\CustomObjects\Dtos\LocationRequestDTO;
use App\CustomObjects\Dtos\RegisterUserDto;
use App\CustomObjects\Dtos\UserResponseDto;
use App\CustomObjects\HttpStatus;
use App\Exceptions\ApiException;
use App\Location;
use App\Role;
use App\User;
use Illuminate\Http\Response;

class UserService
{
    public function register(RegisterUserDto $userDto) {
        $valid = $userDto->validate();
        if ($valid !== null) {
            return $valid;
        } else if (!$this->validateNewUserMail($userDto->getEmail())) {
            return ApiException::report("email already in use",
                HttpStatus::HTTP_CONFLICT, $userDto->getEndpoint());
        } else if (!$this->validateNewUserPhone($userDto->getPhone())) {
            return ApiException::report("phone already in use",
                HttpStatus::HTTP_CONFLICT, $userDto->getEndpoint());
        }
        $user = User::create([
            "email" => $userDto->getEmail(),
            "phone" => $userDto->getPhone(),
            "password" => $userDto->getEncryptedPassword(),
            "name" => $userDto->getFullName()
        ]);
        $role = Role::where('name', 'USER')->get()->first();

        if ($role !== null && $role !== []) {
            $user->roles()->attach($role->id);
        }

        // location
        $location = new Location(
            [
                "name" => $userDto->getLocationName(),
                "formatted_address" => $userDto->getFormattedAddress(),
                "country_code" => $userDto->getCountryCode(),
                "longitude" => $userDto->getLongitude(),
                "latitude" => $userDto->getLatitude()
            ]
        );

        $user->locations()->save($location);
        // prepare roles array
        $roles = [];
        foreach ($user->roles()->get() as $key => $role) {
            $roles[$key] = $role->name;
        }

        return new UserResponseDto(
            $user->name,
            $user->email,
            $user->updated_at,
            $user->id,
            $roles
        );
    }

    public function updateCurrentLocation(LocationRequestDTO $location) {
        $valid = $location->validate();
        if ($valid !== null) {
            return $valid;
        }
        $user = self::getCurrentAuthUser();
        if ($user == null) {
            return ApiException::report("User not found",
                HttpStatus::HTTP_NOT_FOUND, $location->getEndpoint());
        }

        $currentLocation = $user->currentLocation();
        if ($currentLocation == null) {
            $currentLocation = new Location();
            $currentLocation->user_id = $user->id;
        }
        $currentLocation->formatted_address = $location->getFormattedAddress();
        $currentLocation->country_code = $location->getCountryCode();
        $currentLocation->name = $location->getName();
        $currentLocation->longitude = $location->getLongitude();
        $currentLocation->latitude = $location->getLatitude();
        $currentLocation->updated_at = new \DateTime();
        $currentLocation->save();
        return new Response('', 204);
    }

    public function getCurrentLocation($endpoint) {
        $user = self::getCurrentAuthUser();
        if ($user == null) {
            return ApiException::report("User not found",
                HttpStatus::HTTP_NOT_FOUND, $endpoint);
        }
        $location = $user->currentLocation();
        if ($location == null)  return ApiException::report("Current location not set",
            HttpStatus::HTTP_NOT_FOUND, $endpoint);
        return new LocationDTO(
            $location->id,
            $location->formatted_address,
            $location->country_code,
            $location->name,
            $location->longitude,
            $location->latitude
        );
    }

    private function validateNewUserMail($email) {
        $u = User::where("email", $email)->get()->first();
        return $u == null;
    }

    private function validateNewUserPhone($phone) {
        $up = User::where("phone", $phone)->get()->first();
        return $up == null;
    }

    public static function getCurrentAuthUser() {
        $claims = AuthService::getClaims();
        return User::find($claims["userId"]);
    }
}
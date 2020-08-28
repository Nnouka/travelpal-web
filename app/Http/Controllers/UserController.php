<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 1:22 PM
 */

namespace App\Http\Controllers;


use App\CustomObjects\Dtos\LocationRequestDTO;
use App\CustomObjects\Dtos\RegisterUserDto;
use App\CustomObjects\Dtos\UserDetailsResponseDto;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(Request $request) {
        $userDto = new RegisterUserDto(
            $request->input('fullName'),
            $request->input('password'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('formattedAddress'),
            $request->input('countryCode'),
            $request->input('locationName'),
            $request->input('longitude'),
            $request->input('latitude')
        );
        return $this->userService->register($userDto);
    }

    public function registerApp(Request $request) {
        return $this->userService->registerApp();
    }


    public function getDetails(Request $request) {
        $auth = AuthService::getClaims();
        return new UserDetailsResponseDto(
            $auth["userId"],
            $auth["fullName"],
            $auth["email"],
            $auth["roles"]
        );
    }

    public function updateCurrentLocation(Request $request) {
        $location = new LocationRequestDTO(
            $request->input('formattedAddress'),
            $request->input('countryCode'),
            $request->input('longitude'),
            $request->input('latitude'),
            null,
            $request->getRequestUri()
        );

        return $this->userService->updateCurrentLocation($location);
    }


    public function getCurrentLocation(Request $request) {
        return $this->userService->getCurrentLocation($request->getRequestUri());
    }
}
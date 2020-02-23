<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 1:22 PM
 */

namespace App\Http\Controllers;


use App\CustomObjects\Dtos\RegisterUserDto;
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
            $request->input('email')
        );
        return $this->userService->register($userDto);
    }
}
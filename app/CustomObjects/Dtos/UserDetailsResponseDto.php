<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 7/28/20
 * Time: 7:06 PM
 */

namespace App\CustomObjects\Dtos;


use Illuminate\Contracts\Support\Jsonable;

class UserDetailsResponseDto implements Jsonable
{
    private $userId;
    private $fullName;
    private $email;
    private $roles;

    /**
     * UserDetailsResponseDto constructor.
     * @param $userId
     * @param $fullName
     * @param $email
     * @param $roles
     */
    public function __construct($userId, $fullName, $email, $roles)
    {
        $this->userId = $userId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function toJson($options = 0)
    {
        // TODO: Implement toJson() method.
        return json_encode([
            "userId" => $this->getUserId(),
            "fullName" => $this->getFullName(),
            "email" => $this->getEmail(),
            "roles" => $this->getRoles()
        ]);
    }


}
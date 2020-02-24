<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/24/20
 * Time: 7:53 PM
 */

namespace App\CustomObjects\Dtos;


use Illuminate\Contracts\Support\Jsonable;

class UserResponseDto implements Jsonable
{
    private $name;
    private $email;
    private $updatedAt;
    private $userId;
    private $roles;

    /**
     * UserResponseDto constructor.
     * @param $name
     * @param $email
     * @param $updatedAt
     * @param $userId
     * @param $roles
     */
    public function __construct($name, $email, $updatedAt, $userId, $roles)
    {
        $this->name = $name;
        $this->email = $email;
        $this->updatedAt = $updatedAt;
        $this->userId = $userId;
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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


    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        // TODO: Implement toJson() method.
        return json_encode([
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "updatedAt" => $this->getUpdatedAt(),
            "userId" => $this->getUserId(),
            "roles" => $this->getRoles()
        ]);
    }
}
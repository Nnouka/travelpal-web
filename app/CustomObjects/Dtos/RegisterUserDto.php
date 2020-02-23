<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 12:41 PM
 */

namespace App\CustomObjects\Dtos;


use App\CustomObjects\HttpStatus;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;

class RegisterUserDto
{
    private $fullName;
    private $password;
    private $email;
    private $endpoint;

    /**
     * RegisterUserDto constructor.
     * @param $fullName
     * @param $password
     * @param $email
     */
    public function __construct($fullName, $password, $email, $endpoint = '/')
    {
        $this->fullName = $fullName;
        $this->password = $password;
        $this->email = $email;
        $this->endpoint = $endpoint;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * @return null|string
     */
    public function getEncryptedPassword() {
        return $this->getPassword() == null ? null : bcrypt($this->getPassword());
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }



    /**
     * @return \Illuminate\Http\Response|null
     */
    public function validate() {
        $validate = array_unique(array_merge(
            StringValidator::notBlank([
            'password' => $this->getPassword(),
            'email' => $this->getEmail()
        ]),
            StringValidator::email(["email" => $this->getEmail()])
            ));
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }


}
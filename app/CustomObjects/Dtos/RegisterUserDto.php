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
    private $phone;
    private $isDriver;
    private $endpoint;
    private $formattedAddress;
    private $countryCode;
    private $locationName;
    private $longitude;
    private $latitude;

    /**
     * RegisterUserDto constructor.
     * @param $fullName
     * @param $password
     * @param $email
     */
    public function __construct($fullName, $password, $email, $phone,
                                $isDriver = false,
                                $formattedAddress = null, $countryCode = null, $locationName = null, $longitude = null, $latitude = null,
                                $endpoint = '/')
    {
        $this->fullName = $fullName;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->isDriver = $isDriver;
        $this->endpoint = $endpoint;

        // location
        $this->formattedAddress = $formattedAddress;
        $this->countryCode = $countryCode;
        $this->locationName = $locationName ?: 'CURRENT';
        $this->longitude = $longitude;
        $this->latitude = $latitude;
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
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
     * @return null
     */
    public function getFormattedAddress()
    {
        return $this->formattedAddress;
    }

    /**
     * @param null $formattedAddress
     */
    public function setFormattedAddress($formattedAddress)
    {
        $this->formattedAddress = $formattedAddress;
    }

    /**
     * @return null
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param null $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * @param string $locationName
     */
    public function setLocationName($locationName)
    {
        $this->locationName = $locationName;
    }

    /**
     * @return null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param null $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param null $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return bool
     */
    public function isDriver()
    {
        return $this->isDriver;
    }

    /**
     * @param bool $isDriver
     */
    public function setIsDriver($isDriver)
    {
        $this->isDriver = $isDriver;
    }






    /**
     * @return \Illuminate\Http\Response|null
     */
    public function validate() {
        $validate = array_unique(array_merge(
            StringValidator::notBlank([
                'password' => $this->getPassword(),
                'email' => $this->getEmail(),
                'phone' => $this->getPhone()
        ]),
            StringValidator::email(["email" => $this->getEmail()])
            ));
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }


}
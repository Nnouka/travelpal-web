<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/6/20
 * Time: 5:43 AM
 */

namespace App\CustomObjects\Dtos;


use App\CustomObjects\HttpStatus;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;

class LocationRequestDTO
{
    private $formattedAddress;
    private $countryCode;
    private $name;
    private $longitude;
    private $latitude;
    private $endPoint;

    /**
     * LocationRequestDTO constructor.
     * @param $id
     * @param $formattedAddress
     * @param $countryCode
     * @param $name
     * @param $longitude
     * @param $latitude
     * @param $endPoint
     */
    public function __construct($formattedAddress, $countryCode, $longitude, $latitude, $name = null, $endPoint = "/")
    {
        $this->formattedAddress = $formattedAddress;
        $this->countryCode = $countryCode;
        $this->name = $name ?: 'CURRENT';
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->endPoint = $endPoint;
    }


    /**
     * @return mixed
     */
    public function getFormattedAddress()
    {
        return $this->formattedAddress;
    }

    /**
     * @param mixed $formattedAddress
     */
    public function setFormattedAddress($formattedAddress)
    {
        $this->formattedAddress = $formattedAddress;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
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
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @param string $endPoint
     */
    public function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;
    }

    /**
     * @return \Illuminate\Http\Response|null
     */
    public function validate() {
        $validate = StringValidator::notBlank([
            'name' => $this->getName(),
            'longitude' => $this->getLongitude(),
            'latitude' => $this->getLatitude()
        ]);
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }


}
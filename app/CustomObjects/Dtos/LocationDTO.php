<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/6/20
 * Time: 11:17 AM
 */

namespace App\CustomObjects\Dtos;


use Illuminate\Contracts\Support\Jsonable;

class LocationDTO implements Jsonable
{

    private $id;
    private $formattedAddress;
    private $countryCode;
    private $name;
    private $longitude;
    private $latitude;

    /**
     * LocationDTO constructor.
     * @param $id
     * @param $formattedAddress
     * @param $countryCode
     * @param $name
     * @param $longitude
     * @param $latitude
     */
    public function __construct($id, $formattedAddress, $countryCode, $name, $longitude, $latitude)
    {
        $this->id = $id;
        $this->formattedAddress = $formattedAddress;
        $this->countryCode = $countryCode;
        $this->name = $name;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    public function toJson($options = 0)
    {
        // TODO: Implement toJson() method.
        return json_encode([
            "id" => $this->getId(),
            "formattedAddress" => $this->getFormattedAddress(),
            "countryCode" => $this->getCountryCode(),
            "name" => $this->getName(),
            "longitude" => $this->getLongitude(),
            "latitude" => $this->getLatitude()
        ]);
    }


}
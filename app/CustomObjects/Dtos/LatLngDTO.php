<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/10/20
 * Time: 7:30 AM
 */

namespace App\CustomObjects\Dtos;


use App\CustomObjects\HttpStatus;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;

class LatLngDTO
{
    private $lat;
    private $lng;
    private $endpoint;

    /**
     * LatLngDTO constructor.
     * @param $lat
     * @param $lng
     * @param $endpoint
     */
    public function __construct($lat, $lng, $endpoint = "/")
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->endpoint = $endpoint;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
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




    public function validate() {
        $validate = StringValidator::notBlank([
            "lat" => $this->getLat(),
            "lng" => $this->getLng()
        ]);
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }

}
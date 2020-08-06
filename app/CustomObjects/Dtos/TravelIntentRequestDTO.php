<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/6/20
 * Time: 11:35 AM
 */

namespace App\CustomObjects\Dtos;


use App\CustomObjects\HttpStatus;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;

class TravelIntentRequestDTO
{
    private $originFormattedAddress;
    private $originLongitude;
    private $originLatitude;
    private $destinationFormattedAddress;
    private $destinationLongitude;
    private $destinationLatitude;
    private $distance;
    private $duration;
    private $durationText;
    private $endpoint;

    /**
     * TravelIntentRequestDTO constructor.
     * @param $originFormattedAddress
     * @param $originLongitude
     * @param $originLatitude
     * @param $destinationFormattedAddress
     * @param $destinationLongitude
     * @param $destinationLatitude
     * @param $distance
     * @param $duration
     * @param $durationText
     */
    public function __construct($originFormattedAddress, $originLongitude, $originLatitude,
                                $destinationFormattedAddress, $destinationLongitude, $destinationLatitude,
                                $distance, $duration, $durationText, $endpoint = "/")
    {
        $this->originFormattedAddress = $originFormattedAddress;
        $this->originLongitude = $originLongitude;
        $this->originLatitude = $originLatitude;
        $this->destinationFormattedAddress = $destinationFormattedAddress;
        $this->destinationLongitude = $destinationLongitude;
        $this->destinationLatitude = $destinationLatitude;
        $this->distance = $distance;
        $this->duration = $duration;
        $this->durationText = $durationText;
        $this->endpoint = $endpoint;
    }

    /**
     * @return mixed
     */
    public function getOriginFormattedAddress()
    {
        return $this->originFormattedAddress;
    }

    /**
     * @param mixed $originFormattedAddress
     */
    public function setOriginFormattedAddress($originFormattedAddress)
    {
        $this->originFormattedAddress = $originFormattedAddress;
    }

    /**
     * @return mixed
     */
    public function getOriginLongitude()
    {
        return $this->originLongitude;
    }

    /**
     * @param mixed $originLongitude
     */
    public function setOriginLongitude($originLongitude)
    {
        $this->originLongitude = $originLongitude;
    }

    /**
     * @return mixed
     */
    public function getOriginLatitude()
    {
        return $this->originLatitude;
    }

    /**
     * @param mixed $originLatitude
     */
    public function setOriginLatitude($originLatitude)
    {
        $this->originLatitude = $originLatitude;
    }

    /**
     * @return mixed
     */
    public function getDestinationFormattedAddress()
    {
        return $this->destinationFormattedAddress;
    }

    /**
     * @param mixed $destinationFormattedAddress
     */
    public function setDestinationFormattedAddress($destinationFormattedAddress)
    {
        $this->destinationFormattedAddress = $destinationFormattedAddress;
    }

    /**
     * @return mixed
     */
    public function getDestinationLongitude()
    {
        return $this->destinationLongitude;
    }

    /**
     * @param mixed $destinationLongitude
     */
    public function setDestinationLongitude($destinationLongitude)
    {
        $this->destinationLongitude = $destinationLongitude;
    }

    /**
     * @return mixed
     */
    public function getDestinationLatitude()
    {
        return $this->destinationLatitude;
    }

    /**
     * @param mixed $destinationLatitude
     */
    public function setDestinationLatitude($destinationLatitude)
    {
        $this->destinationLatitude = $destinationLatitude;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getDurationText()
    {
        return $this->durationText;
    }

    /**
     * @param mixed $durationText
     */
    public function setDurationText($durationText)
    {
        $this->durationText = $durationText;
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
        $validate = StringValidator::notBlank([
            'originFormattedAddress' => $this->getOriginFormattedAddress(),
            'originLongitude' => $this->getOriginLatitude(),
            'originLatitude' => $this->getOriginLatitude(),
            'destinationFormattedAddress' => $this->getDestinationFormattedAddress(),
            'destinationLongitude' => $this->getDestinationLongitude(),
            'destinationLatitude' => $this->getDestinationLatitude(),
            'distance' => $this->getDistance(),
            'durationText' => $this->getDurationText(),
            'duration' => $this->getDuration()
        ]);
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }


}
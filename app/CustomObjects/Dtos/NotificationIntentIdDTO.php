<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/7/20
 * Time: 9:17 AM
 */

namespace App\CustomObjects\Dtos;


use App\CustomObjects\HttpStatus;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;

class NotificationIntentIdDTO
{
    private $id;
    private $endpoint;

    /**
     * NotificationIntentIdDTO constructor.
     * @param $id
     * @param $endpoint
     */
    public function __construct($id, $endpoint = "/")
    {
        $this->id = $id;
        $this->endpoint = $endpoint;
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
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param mixed $endpoint
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
            'id' => $this->getId()
        ]);
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }


}
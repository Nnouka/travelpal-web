<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/21/20
 * Time: 2:47 PM
 */

namespace App\CustomObjects\Dtos;


use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;
use App\CustomObjects\HttpStatus;
use App\Utils\ToStr;

class RegisterClientDto
{
    private $clientId;
    private $clientSecret;
    private $webServerRedirectUri;
    private $endpoint;

    /**
     * RegisterClientDto constructor.
     * @param $clientId
     * @param $clientSecret
     * @param $webServerRedirectUri
     */
    public function __construct($clientId, $clientSecret, $webServerRedirectUri, $endpoint = '/')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->webServerRedirectUri = $webServerRedirectUri;
        $this->endpoint = $endpoint;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getEncodedClientSecret() {
        return bcrypt($this->getClientSecret());
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    public function getWebServerRedirectUri()
    {
        return $this->webServerRedirectUri;
    }

    /**
     * @param mixed $webServerRedirectUri
     */
    public function setWebServerRedirectUri($webServerRedirectUri)
    {
        $this->webServerRedirectUri = $webServerRedirectUri;
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
            'clientId' => $this->getClientId(),
            'clientSecret' => $this->getClientSecret()
        ]);
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }



}
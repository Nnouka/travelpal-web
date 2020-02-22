<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 11:39 AM
 */

namespace App\CustomObjects\Dtos;


use App\CustomObjects\HttpStatus;
use App\CustomValidators\NumberValidator;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;

class ClientDetailsDto
{

    private $accessTokenValidity;
    private $refreshTokenValidity;
    private $webServerRedirectUri;
    private $endpoint;

    /**
     * ClientDetailsDto constructor.
     * @param $accessTokenValidity
     * @param $refreshTokenValidity
     * @param $webServerRedirectUri
     */
    public function __construct($accessTokenValidity, $refreshTokenValidity, $webServerRedirectUri, $endpoint = '/')
    {
        $this->accessTokenValidity = $accessTokenValidity;
        $this->refreshTokenValidity = $refreshTokenValidity;
        $this->webServerRedirectUri = $webServerRedirectUri;
        $this->endpoint = $endpoint;
    }

    /**
     * @return mixed
     */
    public function getAccessTokenValidity()
    {
        return $this->accessTokenValidity;
    }

    /**
     * @param mixed $accessTokenValidity
     */
    public function setAccessTokenValidity($accessTokenValidity)
    {
        $this->accessTokenValidity = $accessTokenValidity;
    }

    /**
     * @return mixed
     */
    public function getRefreshTokenValidity()
    {
        return $this->refreshTokenValidity;
    }

    /**
     * @param mixed $refreshTokenValidity
     */
    public function setRefreshTokenValidity($refreshTokenValidity)
    {
        $this->refreshTokenValidity = $refreshTokenValidity;
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


    public function validate() {
        $validate = array_unique(array_merge(
            StringValidator::notBlank([
                'webServerRedirectUri' => $this->getWebServerRedirectUri()
            ]),
            NumberValidator::positive([
                'accessTokenValidity' => $this->getAccessTokenValidity(),
                'refreshTokenValidity' => $this->getRefreshTokenValidity()
            ]),
            NumberValidator::notNull([
                'accessTokenValidity' => $this->getAccessTokenValidity(),
                'refreshTokenValidity' => $this->getRefreshTokenValidity()
            ]),
            NumberValidator::lessThan(['accessTokenValidity' => $this->getAccessTokenValidity()], 86400),
            NumberValidator::lessThan(['refreshTokenValidity' => $this->getRefreshTokenValidity()], 2592000)
        ));
        return $validate == [] ? null : ApiException::reportValidationError(
            $validate, HttpStatus::HTTP_BAD_REQUEST, $this->getEndpoint());
    }


}
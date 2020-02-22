<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/21/20
 * Time: 2:45 PM
 */

namespace App\Services;
use App\CustomObjects\Dtos\ClientDetailsDto;
use App\CustomObjects\Dtos\RegisterClientDto;
use App\CustomObjects\HttpStatus;
use App\CustomValidators\NumberValidator;
use App\CustomValidators\StringValidator;
use App\Exceptions\ApiException;
use App\OauthClient;


class OAuthClientService
{
    const DEFAULT_TOKEN_VALIDITY = 3600; // valid for one hour
    const DEFAULT_REFRESH_TOKEN_VALIDITY = 864000; // valid for 10 days
    public function register(RegisterClientDto $registerClientDto) {
        $valid = $registerClientDto->validate();
        if ($valid !== null) {
            return $valid;
        } else if (!$this->validateNewOAuthClient($registerClientDto->getClientId())) {
            return ApiException::report("clientId already in use",
                HttpStatus::HTTP_CONFLICT, $registerClientDto->getEndpoint());
        }
        return OauthClient::create([
            "client_id" => $registerClientDto->getClientId(),
            "client_secret" => $registerClientDto->getEncodedClientSecret(),
            "access_token_validity" => self::DEFAULT_TOKEN_VALIDITY,
            "refresh_token_validity" => self::DEFAULT_REFRESH_TOKEN_VALIDITY,
            "web_server_redirect_uri" => $registerClientDto->getWebServerRedirectUri(),
            "app_key" => OauthClient::generateAppKey()
        ]);
    }

    public function getDetails() {
        return AuthService::get();
    }

    public function setRedirectUri($uri, $endpoint = '/') {
        $valid = StringValidator::notBlank(["webServerRedirectUri" => $uri]);
        if ($valid !== []) {
           return ApiException::reportValidationError(
                $valid, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $client = AuthService::get();
        $client->web_server_redirect_uri = $uri;

        return $client->save() ? $client : ApiException::report("Failed to set uri", HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
            $endpoint);
    }

    public function generateNewAppKey($endpoint = '/') {
        $client = AuthService::get();
        $client->app_key = OauthClient::generateAppKey();
        return $client->save() ? $client : ApiException::report("Failed to set AppKey", HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
            $endpoint);
    }

    public function setAccessTokenValidity($tokenValidity, $endpoint = '/') {
        $validate = ["accessTokenValidity" => $tokenValidity];
        $notNull = NumberValidator::notNull($validate);
        if ($notNull !== []) {
            return ApiException::reportValidationError(
                $notNull, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $lessThan = NumberValidator::lessThan($validate, 864000);
        if ($lessThan !== []) {
            return ApiException::reportValidationError(
                $lessThan, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $positive = NumberValidator::positive($validate);
        if ($positive !== []) {
            return ApiException::reportValidationError(
                $positive, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $client = AuthService::get();
        $client->access_token_validity = $tokenValidity;
        return $client->save() ? $client : ApiException::report("Failed to set AccessTokenValidity", HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
            $endpoint);
    }

    public function setRefreshTokenValidity($tokenValidity, $endpoint = '/') {
        $validate = ["refreshTokenValidity" => $tokenValidity];
        $notNull = NumberValidator::notNull($validate);
        if ($notNull !== []) {
            return ApiException::reportValidationError(
                $notNull, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $lessThan = NumberValidator::lessThan($validate, 2592000);
        if ($lessThan !== []) {
            return ApiException::reportValidationError(
                $lessThan, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $positive = NumberValidator::positive($validate);
        if ($positive !== []) {
            return ApiException::reportValidationError(
                $positive, HttpStatus::HTTP_BAD_REQUEST, $endpoint);
        }
        $client = AuthService::get();
        $client->refresh_token_validity = $tokenValidity;
        return $client->save() ? $client : ApiException::report("Failed to set refreshTokenValidity", HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
            $endpoint);
    }

    public function updateDetails(ClientDetailsDto $clientDetailsDto) {
        $valid = $clientDetailsDto->validate();
        if ($valid !== null) {
            return $valid;
        }
        $client = AuthService::get();
        $client->refresh_token_validity = $clientDetailsDto->getRefreshTokenValidity();
        $client->access_token_validity = $clientDetailsDto->getAccessTokenValidity();
        $client->web_server_redirect_uri = $clientDetailsDto->getWebServerRedirectUri();
        return $client->save() ? $client : ApiException::report("Failed to update details", HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
            $clientDetailsDto->getEndpoint());

    }

    /**
     * @param $clientId
     * @return bool
     */
    public function validateNewOAuthClient($clientId) {
        $oauthClient = OauthClient::where('client_id', $clientId)->get()->first();
        return $oauthClient == null;
    }
}
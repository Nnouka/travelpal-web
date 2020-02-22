<?php

namespace App\Http\Controllers;

use App\CustomObjects\Dtos\ClientDetailsDto;
use Illuminate\Http\Request;
use App\CustomObjects\Dtos\RegisterClientDto;
use App\Services\OAuthClientService;

class OAuthClientController extends Controller
{
    private $authClientService;

    /**
     * OAuthClientController constructor.
     */
    public function __construct()
    {
        $this->authClientService = new OAuthClientService();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|null
     */
    public function register(Request $request) {
       $client = new RegisterClientDto(
           $request->input('clientId'),
           $request->input('clientSecret'),
           $request->input('webServerRedirectUri'),
           $request->getRequestUri()
       );
       return $this->authClientService->register($client);
    }

    /**
     * @return mixed
     */
    public function getClientDetails() {
        return $this->authClientService->getDetails();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function setWebServerRedirectUri(Request $request) {
        return $this->authClientService->setRedirectUri($request->input('webServerRedirectUri'),
            $request->getRequestUri());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateAppKey(Request $request) {
        return $this->authClientService->generateNewAppKey($request->getRequestUri());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function setAccessTokenValidity(Request $request) {
        return $this->authClientService->setAccessTokenValidity(
            $request->input('access_token_validity'), $request->getRequestUri()
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function setRefreshTokenValidity(Request $request) {
        return $this->authClientService->setRefreshTokenValidity(
            $request->input('refresh_token_validity'), $request->getRequestUri()
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|null
     */
    public function updateClientDetails(Request $request) {
        $details = new ClientDetailsDto(
            $request->input("access_token_validity"),
            $request->input("refresh_token_validity"),
            $request->input("web_server_redirect_uri"),
            $request->getRequestUri()
        );
        return $this->authClientService->updateDetails($details);
    }
}

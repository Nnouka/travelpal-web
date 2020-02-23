<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/22/20
 * Time: 9:11 AM
 */

namespace App\Services;


use App\CustomObjects\HttpStatus;
use App\Exceptions\ApiException;
use App\OauthClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class AuthService
{
    private static $auth;
    public static function check(Request $request) {
        $header_str = $request->header("X-Api-Auth", '');
        // get the header string expect a string formatted as Basic clientId:clientSecret
        if (!Str::contains($header_str, "Basic")) {
            return false;
        } else {
            try {
                // decode header
                $credentialObj = base64_decode(trim(str_replace('Basic', '', $header_str)));
            } catch (Exception $ex) {
                return false;
            } if(!Str::contains($credentialObj, ':')) {
                return false;
            } else {
                $credentialObj = explode(':', $credentialObj);
                $clientId = $credentialObj[0];
                $clientSecret = $credentialObj[1];
                $client = OauthClient::where("client_id", $clientId)->get()->first();
                if ($client == null) {
                    return false;
                }else if (!Hash::check($clientSecret, $client->client_secret)) {
                    return false;
                } else {
                    self::$auth = $client;
                    return true;
                }
            }
        }
    }

    public static function get() {
        return self::$auth;
    }
}
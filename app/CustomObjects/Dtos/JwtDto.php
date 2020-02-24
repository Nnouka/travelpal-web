<?php
/**
 * Created by PhpStorm.
 * User: nouks
 * Date: 2/24/20
 * Time: 5:41 PM
 */

namespace App\CustomObjects\Dtos;


use Illuminate\Contracts\Support\Jsonable;

class JwtDto implements Jsonable
{

    private $header;
    private $issuer;
    private $accessToken;
    private $type;
    private $expiresAt;

    /**
     * JwtDto constructor.
     * @param $header
     * @param $issuer
     * @param $accessToken
     * @param $type
     * @param $expiresAt
     */
    public function __construct($header, $issuer, $accessToken, $type, $expiresAt)
    {
        $this->header = $header;
        $this->issuer = $issuer;
        $this->accessToken = $accessToken;
        $this->type = $type;
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param mixed $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param mixed $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
       return json_encode([
           "header" => $this->getHeader(),
           "issuer" => $this->getIssuer(),
           "accessToken" => $this->getAccessToken(),
           "type" => $this->getType(),
           "expiresAt" => $this->getExpiresAt()
       ]);
    }

}
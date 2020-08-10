<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/10/20
 * Time: 7:38 AM
 */

namespace App\CustomObjects\Dtos;


use Illuminate\Contracts\Support\Jsonable;

class DriversDTO implements Jsonable
{

    private $drivers = [];

    /**
     * driversDTO constructor.
     * @param array $drivers
     */
    public function __construct(array $drivers)
    {
        $this->drivers = $drivers;
    }

    /**
     * @return array
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * @param array $drivers
     */
    public function setDrivers($drivers)
    {
        $this->drivers = $drivers;
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
            "drivers" => $this->drivers
        ]);

    }
}
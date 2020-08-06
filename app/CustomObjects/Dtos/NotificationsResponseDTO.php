<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/6/20
 * Time: 1:57 PM
 */

namespace App\CustomObjects\Dtos;


use Illuminate\Contracts\Support\Jsonable;

class NotificationsResponseDTO implements Jsonable
{
    private $notifications = [];

    public function addNotification($notification) {
        array_push($this->notifications, $notification);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    public function toJson($options = 0)
    {
        // TODO: Implement toJson() method.
        return json_encode(
            ["notifications" => $this->getNotifications()]
        );
    }


}
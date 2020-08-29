<?php
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 8/6/20
 * Time: 11:34 AM
 */

namespace App\Services;


use App\CustomObjects\Dtos\DriversDTO;
use App\CustomObjects\Dtos\LatLngDTO;
use App\CustomObjects\Dtos\NotificationIntentIdDTO;
use App\CustomObjects\Dtos\NotificationsResponseDTO;
use App\CustomObjects\Dtos\TravelIntentRequestDTO;
use App\CustomObjects\HttpStatus;
use App\Exceptions\ApiException;
use App\Location;
use App\Notifications\TravelIntent;
use App\Travel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class TravelService
{
    const ORIGIN = "ORIGIN";
    const DESTINATION = "DESTINATION";
    public function registerTravelIntent(TravelIntentRequestDTO $travelIntent) {
        // validate
        $valid = $travelIntent->validate();
        if ($valid !== null) {
            return $valid;
        }

        // get user
        $user = UserService::getCurrentAuthUser();
        if ($user == null) {
            return ApiException::report("User not found",
                HttpStatus::HTTP_NOT_FOUND, $travelIntent->getEndpoint());
        }
        // get and save location
        $origin = new Location(
            [
                "user_id" => $user->id,
                "name" => self::ORIGIN,
                "formatted_address" => $travelIntent->getOriginFormattedAddress(),
                "longitude" => $travelIntent->getOriginLongitude(),
                "latitude" => $travelIntent->getOriginLatitude(),
            ]
        );
        $destination = new Location(
            [
                "user_id" => $user->id,
                "name" => self::DESTINATION,
                "formatted_address" => $travelIntent->getDestinationFormattedAddress(),
                "longitude" => $travelIntent->getDestinationLongitude(),
                "latitude" => $travelIntent->getDestinationLatitude(),
            ]
        );
        $origin->save();
        $destination->save();
        // save travel
        $travel = new Travel([
            "origin_location_id" => $origin->id,
            "destination_location_id" => $destination->id,
            "distance" => $travelIntent->getDistance(),
            "duration" => $travelIntent->getDuration(),
            "duration_text" => $travelIntent->getDurationText(),
            "price" => $travelIntent->getPrice(),
            "notified_at" => Carbon::now()
        ]);
        $user->travels()->save($travel);
        // get drivers
        $nearByDrivers = $user->nearDrivers($origin->longitude, $origin->latitude, $user->id);
        // notify drivers
        foreach ($nearByDrivers as $driver) {
            $notifying = $driver["driver"];
            $notifying->notify(new TravelIntent($travelIntent));
        }
        // return list of drivers notified

        return new Response('true', 204);
    }

    public function getUnreadTravelIntentNotifications($endpoint) {
         $TYPE = "App\Notifications\TravelIntent";
         $Intent = "TravelIntent";
        $user = UserService::getCurrentAuthUser();
        if ($user == null) {
            return ApiException::report("User not found",
                HttpStatus::HTTP_NOT_FOUND, $endpoint);
        }

        $notifications = new NotificationsResponseDTO();
        foreach ($user->unreadNotifications as $notification) {
            if ($notification->type == $TYPE) $notifications->addNotification(
                [
                    "type" => $Intent,
                    "data" => $notification->data,
                    "id" => $notification->id
                ]);
        }

        return $notifications;

    }

    public function markTravelIntentNotificationAsRead(NotificationIntentIdDTO $idDTO) {
        // validate
        $valid = $idDTO->validate();
        if ($valid !== null) {
            return $valid;
        }
        // mark as read
        User::markNotificationAsRead($idDTO->getId());

        return new Response('', 204);
    }

    public function markAllTravelIntentNotificationsAsRead($endpoint) {
        $user = UserService::getCurrentAuthUser();
        if ($user == null) {
            return ApiException::report("User not found",
                HttpStatus::HTTP_NOT_FOUND, $endpoint);
        }
        User::markAllTravelIntentNotificationsAsRead($user->id);
        return new Response('', 204);
    }

    public function getNearByDrivers(LatLngDTO $latLng) {
        $user = UserService::getCurrentAuthUser();
        if ($user == null) {
            return ApiException::report("User not found",
                HttpStatus::HTTP_NOT_FOUND, $latLng->getEndpoint());
        }

        $drivers = $user->nearDrivers($latLng->getLng(), $latLng->getLat(), $user->id);
        return new DriversDTO($drivers);
    }

    public static function nearby() {
        $user = new User();
        return $user->nearDrivers(2.1211, 13.123, 5);
    }

}
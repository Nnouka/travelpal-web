<?php

namespace App\Http\Controllers;

use App\CustomObjects\Dtos\NotificationIntentIdDTO;
use App\CustomObjects\Dtos\TravelIntentRequestDTO;
use App\Services\TravelService;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    //

    private $travelService;

    /**
     * TravelController constructor.
     * @param $travelService
     */
    public function __construct()
    {
        $this->travelService = new TravelService();
    }

    public function registerTravelIntent(Request $request) {
        $travelIntent = new TravelIntentRequestDTO(
            $request->input('originFormattedAddress'),
            $request->input('originLongitude'),
            $request->input('originLatitude'),
            $request->input('destinationFormattedAddress'),
            $request->input('destinationLongitude'),
            $request->input('destinationLatitude'),
            $request->input('distance'),
            $request->input('duration'),
            $request->input('durationText'),
            $request->input('price'),
            $request->getRequestUri()
        );

        return $this->travelService->registerTravelIntent($travelIntent);
    }

    public function getUnreadTravelIntentNotifications(Request $request) {
        return $this->travelService->getUnreadTravelIntentNotifications($request->getRequestUri());
    }

    public function markUnreadTravelIntentNotificationAsRead(Request $request) {
        return $this->travelService->markTravelIntentNotificationAsRead(
            new NotificationIntentIdDTO(
                $request->input('id'),
                $request->getRequestUri()
            )
        );
    }

    public function markAllUnreadTravelIntentNotificationAsRead(Request $request){
        return $this->travelService->markAllTravelIntentNotificationsAsRead($request->getRequestUri());
    }


}

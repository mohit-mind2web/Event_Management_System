<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;

class EventsController extends BaseController
{
    public function index()
    {
        $events = new EventModel();
        $eventdetails = $events->where('status', 1)->findAll();

        $userRegistrations = [];
        if (auth()->loggedIn()) {
            $registrationModel = new  EventRegistrationModel();
            $registrations = $registrationModel->where('user_id', auth()->user()->id)
                                               ->findAll();
            
            foreach ($registrations as $reg) {
                $userRegistrations[$reg['event_id']] = $reg;
            }
        }

        return view('user/events', [
            'eventdetails' => $eventdetails,
            'userRegistrations' => $userRegistrations
        ]);
    }
}

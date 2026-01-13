<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventsController extends BaseController
{
    public function index()
    {
        $events = new EventModel();
        $eventdetails = $events->where('status', 1)->findAll();

        $registeredEventIds = [];
        if (auth()->loggedIn()) {
            $registrationModel = new \App\Models\EventRegistrationModel();
            $registrations = $registrationModel->select('event_id')
                                               ->where('user_id', auth()->user()->id)
                                               ->findAll();
            $registeredEventIds = array_column($registrations, 'event_id');
        }

        return view('user/events', [
            'eventdetails' => $eventdetails,
            'registeredEventIds' => $registeredEventIds
        ]);
    }
}

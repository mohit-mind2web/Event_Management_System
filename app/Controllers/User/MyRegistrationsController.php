<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventRegistrationModel;
use App\Models\EventModel;

class MyRegistrationsController extends BaseController
{
    public function index()
    {
        $registrationModel = new EventRegistrationModel();
        $userId = auth()->user()->id;

        // Fetch user's registrations along with event details
        $registrations = $registrationModel->where('user_id', $userId)
                                           ->orderBy('created_at', 'DESC')
                                           ->findAll();

        $eventModel = new EventModel();
        foreach ($registrations as &$reg) {
            $reg['event'] = $eventModel->find($reg['event_id']);
        }

        return view('user/my_registrations', ['registrations' => $registrations]);
    }
}

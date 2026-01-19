<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;

class TicketController extends BaseController
{
    public function index($registrationId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to view your ticket.');
        }

        $registrationModel = new EventRegistrationModel();
        $registration = $registrationModel->find($registrationId);

        if (!$registration) {
            return redirect()->back()->with('error', 'Registration not found.');
        }

        // Access Control: Ensure the ticket belongs to the logged-in user
        if ($registration['user_id'] != auth()->user()->id) {
            return redirect()->to('/user/events')->with('error', 'Unauthorized access to ticket.');
        }

        // Access Control: Ensure payment is completed
        if ($registration['payment_status'] !== 'paid' && $registration['payment_status'] !== 'free') {
             return redirect()->to('/user/events/summary/' . $registration['event_id'])
                            ->with('error', 'Please complete payment to view your ticket.');
        }

        $eventModel = new EventModel();
        $event = $eventModel->find($registration['event_id']);

        if (!$event) {
            return redirect()->back()->with('error', 'Event details not found.');
        }

        return view('user/ticket', [
            'registration' => $registration,
            'event' => $event,
            'user' => auth()->user()
        ]);
    }
}

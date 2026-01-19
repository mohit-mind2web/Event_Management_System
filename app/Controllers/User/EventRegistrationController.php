<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;

class EventRegistrationController extends BaseController
{
    public function register($eventId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to register for events.');
        }

        $eventModel = new EventModel();
        $registrationModel = new EventRegistrationModel();
        
        $userId = auth()->user()->id;
        $event = $eventModel->find($eventId);

        // Validation Checks
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        if ($event['status'] != 1) { 
             return redirect()->back()->with('error', 'This event is not active.');
        }

        $currentDate = date('Y-m-d H:i:s');
        if ($event['start_datetime'] < $currentDate) {
             return redirect()->back()->with('error', 'Event has already started or finished.');
        }

        $existingReg = $registrationModel->where('event_id', $eventId)
                                         ->where('user_id', $userId)
                                         ->first();
        if ($existingReg) {
            // If paid event and incomplete payment, allow them to proceed to summary (which handles payment)
            if ($event['is_paid'] && $existingReg['payment_status'] != 'paid') {
                 return redirect()->to('/user/events/summary/' . $eventId);
            }
            return redirect()->back()->with('message', 'You are already registered for this event.');
        }

        $currentCount = $registrationModel->where('event_id', $eventId)->countAllResults();
        if ($currentCount >= $event['capacity']) {
             return redirect()->back()->with('error', 'Event is fully booked.');
        }

        // Redirect ALL to Summary Page
        return redirect()->to('/user/events/summary/' . $eventId);
    }

    public function summary($eventId)
    {
        $eventModel = new EventModel();
        $userId = auth()->user()->id;
        $event = $eventModel->select('events.*,event_registrations.payment_status as payment_status,
                                        event_registrations.status as registration_status')
                            ->join('event_registrations', 'events.id = event_registrations.event_id AND event_registrations.user_id = ' . $userId, 'left')
                            ->where('events.id', $eventId)
                            ->first();

        if (!$event) {
            return redirect()->to('/user/events')->with('error', 'Event not found.');
        }

        // Re-check registration to avoid double dipping if they just refreshed
        $registrationModel = new EventRegistrationModel();
        $existingReg = $registrationModel->where('event_id', $eventId)
                                         ->where('user_id', auth()->user()->id)
                                         ->first();

        // If it's a paid event and they are already registered but unpaid, we still show summary to let them pay.
        // If free and registered, kick them out.
        if ($existingReg && (!$event['is_paid'] || $existingReg['payment_status'] == 'paid')) {
             return redirect()->to('/user/events')->with('message', 'You have already registered for this event.');
        }

        return view('user/registration_summary', ['event' => $event]);
    }

    public function confirm()
    {
        $eventId = $this->request->getPost('event_id');
        $userId = auth()->user()->id;

        $eventModel = new EventModel();
        $event = $eventModel->find($eventId);

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Double check paid status - this method is ONLY for free events
        if ($event['is_paid']) {
            return redirect()->back()->with('error', 'Invalid operation for paid event.');
        }

        $registrationModel = new EventRegistrationModel();
        
        // Final check on duplicates
        $existingReg = $registrationModel->where('event_id', $eventId)
                                         ->where('user_id', $userId)
                                         ->first();
        if ($existingReg) {
            return redirect()->to('/user/registrations')->with('message', 'Already registered.');
        }

        $data = [
            'event_id' => $eventId,
            'user_id' => $userId,
            'registration_date' => date('Y-m-d H:i:s'),
            'status' => 'confirmed',
            'payment_status' => 'free',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($registrationModel->insert($data)) {
            return redirect()->to('/user/registrations')->with('message', 'Successfully registered for ' . $event['title']);
        } else {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }
}

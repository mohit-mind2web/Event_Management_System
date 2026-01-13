<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\PaymentModel;

class EventRegistrationController extends BaseController
{
    public function register($eventId)
    {
        $eventModel = new EventModel();
        $registrationModel = new EventRegistrationModel();
        
        $userId = auth()->user()->id;
        $event = $eventModel->find($eventId);

        // check event is valid or not
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // chekck event is active or not 
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
            return redirect()->back()->with('message', 'You are already registered for this event.');
        }

        $currentCount = $registrationModel->where('event_id', $eventId)->countAllResults();
        if ($currentCount >= $event['capacity']) {
             return redirect()->back()->with('error', 'Event is fully booked.');
        }

        // Payment
        if ($event['is_paid']) {
             return redirect()->to('/user/events/payment/' . $eventId);
        } else {
             $data = [
                 'event_id' => $eventId,
                 'user_id' => $userId,
                 'registration_date' => date('Y-m-d H:i:s'),
                 'status' => 'confirmed',
                 'payment_status' => 'free'
             ];
             
             $registrationModel->save($data);
             return redirect()->back()->with('message', 'Successfully registered for ' . $event['title']);
        }
    }

    public function payment($eventId)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($eventId);
        
        if (!$event || !$event['is_paid']) {
            return redirect()->to('/user/events');
        }

        return view('user/payment_page', ['event' => $event]);
    }

    public function processPayment()
    {
        $eventModel = new EventModel();
        $registrationModel = new EventRegistrationModel();
        $paymentModel = new PaymentModel();

        $eventId = $this->request->getPost('event_id');
        $userId = auth()->user()->id;
        $amount = $this->request->getPost('amount');
        
        // Mock Payment Processing
        $transactionId = 'TXN_' . strtoupper(uniqid());
        $status = 'success'; // Assume success for now

        // 1. Create Registration Check (Re-verify capacity to be safe)
        $event = $eventModel->find($eventId);
        // ... (can add re-validation here)

        $regData = [
             'event_id' => $eventId,
             'user_id' => $userId,
             'registration_date' => date('Y-m-d H:i:s'),
             'status' => 'confirmed',
             'payment_status' => 'paid'
         ];
         $registrationModel->save($regData);
         $registrationId = $registrationModel->getInsertID();

         // 2. Create Payment Record
         $payData = [
             'user_id' => $userId,
             'event_id' => $eventId,
             'registration_id' => $registrationId,
             'amount' => $amount,
             'transaction_id' => $transactionId,
             'payment_date' => date('Y-m-d H:i:s'),
             'status' => $status
         ];
         $paymentModel->save($payData);

         return redirect()->to('/user/registrations')->with('message', 'Payment successful! Registration confirmed.');
    }
}

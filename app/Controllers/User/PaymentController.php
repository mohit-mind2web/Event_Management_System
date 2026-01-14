<?php

namespace App\Controllers\User;
use App\Models\EventRegistrationModel;
use App\Models\EventModel;
use App\Models\PaymentModel;
use App\Controllers\BaseController;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends BaseController
{
    public function summary($eventId)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($eventId);

        if (!$event) {
            return redirect()->to('/user/events')->with('error', 'Event not found.');
        }

        return view('user/payment_summary', ['event' => $event]);
    }

    public function checkout()
    {
        $eventId = $this->request->getPost('event_id');
        $eventModel = new EventModel();
        $event = $eventModel->find($eventId);

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $userId = auth()->user()->id;
        $registrationModel = new EventRegistrationModel();
        
        // check if already registered
        $existingRegistration = $registrationModel->where('user_id', $userId)
                                                  ->where('event_id', $eventId)
                                                  ->first();

        if ($existingRegistration) {
             if ($existingRegistration['payment_status'] == 'paid') {
                 return redirect()->to('/user/events')->with('message', 'You are already registered and paid for this event.');
             }
             $registrationId = $existingRegistration['id'];
        } else {
            $registrationData = [
                'event_id' => $eventId,
                'user_id' => $userId,
                'registration_date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $registrationId = $registrationModel->insert($registrationData);
        }

        // Stripe Checkout
        Stripe::setApiKey(getenv('STRIPE_SECRET'));

        $domain = base_url();

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $event['title'],
                        'description' => 'Registration for ' . $event['title'],
                    ],
                    'unit_amount' => $event['price'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $domain . '/user/payment/success?session_id={CHECKOUT_SESSION_ID}&registration_id=' . $registrationId,
            'cancel_url' => $domain . '/user/payment/cancel?event_id=' . $eventId,
        ]);

        return redirect()->to($checkout_session->url);
    }

    public function success()
    {
        $sessionId = $this->request->getGet('session_id');
        $registrationId = $this->request->getGet('registration_id');

        if (!$sessionId || !$registrationId) {
            return redirect()->to('/user/events')->with('error', 'Invalid payment session.');
        }

        Stripe::setApiKey(getenv('STRIPE_SECRET'));

        try {
            $session = Session::retrieve($sessionId);

            $registrationModel = new EventRegistrationModel();

            if ($session->payment_status == 'paid') {
                $paymentModel = new PaymentModel();
                $existingPayment = $paymentModel->where('transaction_id', $session->payment_intent)->first();

                if (!$existingPayment) {
                    // Update Registration
                    $registrationModel->update($registrationId, [
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    // Insert Payment Record
                    $paymentModel->insert([
                        'user_id' => auth()->user()->id,
                        'event_id' => $registrationModel->find($registrationId)['event_id'],
                        'registration_id' => $registrationId,
                        'amount' => $session->amount_total / 100,
                        'transaction_id' => $session->payment_intent,
                        'payment_date' => date('Y-m-d H:i:s'),
                        'status' => 'success',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }

                return view('user/payment_success', [
                    'transaction_id' => $session->payment_intent,
                    'amount' => $session->amount_total / 100,
                    'date' => date('Y-m-d H:i:s'),
                    'registration_id' => $registrationId
                ]);
            } else {
                // Payment failed or incomplete
                $eventId = $registrationModel->find($registrationId)['event_id'];
                return view('user/payment_failed', [
                    'event_id' => $eventId,
                    'error_message' => 'Payment status: ' . $session->payment_status
                ]);
            }
        } catch (\Exception $e) {
             return view('user/payment_failed', ['error_message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function cancel()
    {
        $eventId = $this->request->getGet('event_id');
        return view('user/payment_failed', [
            'event_id' => $eventId,
            'error_message' => 'Payment was cancelled by the user.'
        ]);
    }
}

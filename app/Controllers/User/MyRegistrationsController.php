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
        $eventModel = new EventModel();

        $query = $registrationModel->where('user_id', $userId);

        // Filter: Status
        $status = $this->request->getGet('status');
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Filter: Payment Status
        $paymentStatus = $this->request->getGet('payment_status');
        if (!empty($paymentStatus)) {
            $query->where('payment_status', $paymentStatus);
        }

        // Fetch user's registrations along with event details
        $registrations = $query->orderBy('created_at', 'DESC')->paginate(10);
        $pager = $registrationModel->pager;

        foreach ($registrations as &$reg) {
            $reg['event'] = $eventModel->find($reg['event_id']);
        }

        $data = [
            'registrations' => $registrations,
            'pager' => $pager
        ];

        if ($this->request->isAJAX()) {
            return view('user/partials/registrations_list', $data);
        }

        return view('user/my_registrations', $data);
    }
}

<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;
use App\Models\EventModel;

use App\Models\EventRegistrationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $eventRegistrationModel = new EventRegistrationModel();
        $userId = auth()->user()->id;

        // Statistics
        $totalEvents = $eventModel->where('organizer_id', $userId)->countAllResults();
        $approvedEvents = $eventModel->where('organizer_id', $userId)->where('status', 1)->countAllResults();
        $pendingEvents = $eventModel->where('organizer_id', $userId)->where('status', 0)->countAllResults();
        
        // Calculate Total Registrations for all events of this organizer
        $organizerEventIds = $eventModel->where('organizer_id', $userId)->findColumn('id') ?? [];
        $totalRegistrations = 0;
        if (!empty($organizerEventIds)) {
            $totalRegistrations = $eventRegistrationModel->whereIn('event_id', $organizerEventIds)->countAllResults();
        }

        // Recent Events
        $currentDate = date('Y-m-d H:i:s');
        $recentEvents = $eventModel->where('organizer_id', $userId)
                                   ->groupStart()
                                       ->where('end_datetime <', $currentDate)
                                       ->where('status !=', 2)
                                   ->groupEnd()
                                   ->orderBy('end_datetime', 'DESC')
                                   ->findAll(5);

        // Attach registration count to recent events
        foreach ($recentEvents as &$event) {
            $event['registrations_count'] = $eventRegistrationModel->where('event_id', $event['id'])->countAllResults();
        }

        // Upcoming Events
        $upcomingEvents = $eventModel->where('organizer_id', $userId)
                                     ->where('end_datetime >=', $currentDate)
                                     ->where('status !=', 2)
                                     ->orderBy('start_datetime', 'ASC')
                                     ->findAll(5);

        return view('organizer/dashboard', [
            'totalEvents' => $totalEvents,
            'approvedEvents' => $approvedEvents,
            'pendingEvents' => $pendingEvents,
            'totalRegistrations' => $totalRegistrations,
            'recentEvents' => $recentEvents,
            'upcomingEvents' => $upcomingEvents
        ]);
    }
}

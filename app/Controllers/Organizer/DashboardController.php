<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;
use App\Models\EventModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $userId = auth()->user()->id;

        // Statistics
        $totalEvents = $eventModel->where('organizer_id', $userId)->countAllResults();
        $approvedEvents = $eventModel->where('organizer_id', $userId)->where('status', 1)->countAllResults();
        $pendingEvents = $eventModel->where('organizer_id', $userId)->where('status', 0)->countAllResults();
        $totalRegistrations = 0; 

        // Recent Events
        $currentDate = date('Y-m-d H:i:s');
        $recentEvents = $eventModel->where('organizer_id', $userId)->groupStart() ->where('end_datetime <', $currentDate) ->orWhere('status', 2)
                                   ->groupEnd()
                                   ->orderBy('end_datetime', 'DESC')
                                   ->findAll(5);

        // Upcoming Events
        $upcomingEvents = $eventModel->where('organizer_id', $userId)
                                     ->where('start_datetime >', $currentDate)
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

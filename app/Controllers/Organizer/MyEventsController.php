<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;
use App\Models\EventModel;

class MyEventsController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $userId = auth()->user()->id;
        
        // Fetch events created by this organizer
        $events = $eventModel->where('organizer_id', $userId)
                             ->orderBy('created_at', 'DESC')
                             ->findAll();

        return view('organizer/myevents', ['events' => $events]);
    }
}

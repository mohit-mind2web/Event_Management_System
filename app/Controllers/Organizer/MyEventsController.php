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
        
        $search = $this->request->getGet('search');
        $dateRange = $this->request->getGet('date_range');
        $status = $this->request->getGet('status');
        
        $startDate = null;
        $endDate = null;

        if ($dateRange) {
            $dates = explode(' to ', $dateRange);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1] . ' 23:59:59'; // Include end of day
            } elseif (count($dates) == 1) {
                 $startDate = $dates[0];
                 $endDate = $dates[0] . ' 23:59:59';
            }
        }

        $query = $eventModel->where('organizer_id', $userId);

        if ($search) {
            $query->like('title', $search);
        }
        
        if ($startDate) {
            $query->where('start_datetime >=', $startDate);
        }
        
        if ($endDate) {
            $query->where('end_datetime <=', $endDate);
        }
        
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        $events = $query->orderBy('created_at', 'DESC')->paginate(5);
        $pager = $query->pager;
        
        $data = [
            'events' => $events, 
            'pager' => $pager,
            'search' => $search,
            'date_range' => $dateRange,
            'status' => $status
        ];

        if ($this->request->isAJAX()) {
            return view('organizer/partials/myevents_table', $data);
        }

        return view('organizer/myevents', $data);
    }
}

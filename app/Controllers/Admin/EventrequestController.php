<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventrequestController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        
        $title = $this->request->getGet('title');
        $date = $this->request->getGet('date');
        
        // Base query for pending events
        $query = $eventModel->where('status', 0);
        
        if ($title) {
            $query->like('title', $title);
        }
        
         if ($date) {
            $dates = explode(' to ', $date);
            if (count($dates) == 2) {
                $query->where('date(start_datetime) >=', $dates[0])
                      ->where('date(start_datetime) <=', $dates[1]);
            } else {
                 $query->where('date(start_datetime)', $date);
            }
        }
        
        $events = $query->orderBy('created_at', 'ASC')->paginate(10);
        
        $data = [
            'events' => $events,
            'pager' => $eventModel->pager,
            'title' => $title,
            'date' => $date
        ];

        if ($this->request->isAJAX()) {
            return view('admin/partials/eventapproval_table', $data);
        }

        return view('admin/eventapproval', $data);
    }
}

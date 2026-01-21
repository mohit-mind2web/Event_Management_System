<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\EventModel;
class AlleventsController extends BaseController {
    public function index()
    {
        $events = new EventModel();

        $title = $this->request->getGet('title');
        $status = $this->request->getGet('status');
        $date = $this->request->getGet('date');

        if ($title) {
            $events->like('title', $title);
        }

        if ($status !== null && $status !== '') {
            $events->where('status', $status);
        }

         if ($date) {
            $dates = explode(' to ', $date);
            if (count($dates) == 2) {
                $events->where('date(start_datetime) >=', $dates[0])
                       ->where('date(start_datetime) <=', $dates[1]);
            } else {
                 $events->where('date(start_datetime)', $date);
            }
        }

        $eventsdata = $events->orderBy('created_at', 'DESC')->paginate(10);
        
        $data = [
            'eventsdata' => $eventsdata,
            'pager' => $events->pager
        ];

        if ($this->request->isAJAX()) {
            return view('admin/partials/events_table', $data);
        }

        return view('admin/allevents', $data);
    }
}
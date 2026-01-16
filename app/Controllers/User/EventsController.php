<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;

class EventsController extends BaseController
{
    public function index()
    {
        $events = new EventModel();
        $query = $events->where('status', 1);

        // Filter: Search
        $search = $this->request->getGet('q');
        if (!empty($search)) {
            $query->groupStart()
                ->like('title', $search)
                ->orLike('location', $search)
                ->groupEnd();
        }

        // Filter: Price
        $price = $this->request->getGet('price');
        if ($price === 'free') {
            $query->where('is_paid', 0);
        } elseif ($price === 'paid') {
            $query->where('is_paid', 1);
        }

        // Filter: Date
        $dateFilter = $this->request->getGet('date');
        $today = date('Y-m-d');
        if ($dateFilter === 'today') {
            $query->where('DATE(start_datetime)', $today);
        } elseif ($dateFilter === 'tomorrow') {
            $tomorrow = date('Y-m-d', strtotime('+1 day'));
            $query->where('DATE(start_datetime)', $tomorrow);
        } elseif ($dateFilter === 'week') {
            $query->where('YEARWEEK(start_datetime, 1)', date('YEARWEEK(CURDATE(), 1)'));
        } elseif ($dateFilter === 'month') {
            $query->where('MONTH(start_datetime)', date('m'))
                  ->where('YEAR(start_datetime)', date('Y'));
        }

        // Filter: Category
        $categoryFilter = $this->request->getGet('category');
        if (!empty($categoryFilter)) {
            $query->where('category_id', $categoryFilter);
        }

        // Execute query
        $eventdetails = $query->orderBy('start_datetime', 'ASC')->paginate(9);
        $pager = $events->pager;
        
        // Fetch Categories for Filter
        $categoryModel = new \App\Models\CategoryModel();
        $categories = $categoryModel->findAll();

        $userRegistrations = [];
        if (auth()->loggedIn()) {
            $registrationModel = new EventRegistrationModel();
            $registrations = $registrationModel->where('user_id', auth()->user()->id)
                                               ->findAll();
            
            foreach ($registrations as $reg) {
                $userRegistrations[$reg['event_id']] = $reg;
            }
        }

        $data = [
            'eventdetails' => $eventdetails,
            'userRegistrations' => $userRegistrations,
            'pager' => $pager,
            'categories' => $categories
        ];

        if ($this->request->isAJAX()) {
            return view('user/partials/events_list', $data);
        }

        return view('user/events', $data);
    }
}

<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;

use App\Models\EventModel;

class HomeController extends Controller {
    public function index() {
        $eventModel = new EventModel();
        $upcomingEvents = $eventModel->where('start_datetime >', date('Y-m-d H:i:s'))
                                      ->where('status', 1) 
                                     ->orderBy('start_datetime', 'ASC')
                                     ->findAll(3);
        return view('user/home', ['upcomingEvents' => $upcomingEvents]);
    }
}
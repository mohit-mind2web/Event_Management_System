<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventrequestController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $events = $eventModel->where('status', 0)->orderBy('created_at', 'ASC')->findAll();

        return view('admin/eventapproval', ['events' => $events]);
    }
}

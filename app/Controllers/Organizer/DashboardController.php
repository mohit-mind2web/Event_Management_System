<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('organizer/dashboard');
    }
}

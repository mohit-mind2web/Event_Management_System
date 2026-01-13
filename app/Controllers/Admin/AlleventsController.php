<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\EventModel;
 class AlleventsController extends BaseController{
    public function index()
    {
        $events=new EventModel();
        $eventsdata=$events->orderBy('created_at','DESC')->findAll();

        return view('admin/allevents', ['eventsdata' => $eventsdata]);
    }
 }
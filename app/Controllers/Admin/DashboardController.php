<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\PaymentModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $eventModel=new EventModel();
        $eventRegistrationModel=new EventRegistrationModel();
        $paymentModel=new PaymentModel();
        $data['events']=[
            'total'=>$eventModel->where('COUNT(*) AS total'),
            'approved'=>$eventModel->where('status',1)->countAllResults(),
            'pending'=>$eventModel->where('status',0)->countAllResults(),
            'rejected'=>$eventModel->where('status',2)->countAllResults()
        ];
        $data['payments']=$paymentModel->select('MONTH(created_at) as month,SUM(amount) as total')->where('status','success')
                          ->groupBy('MONTH(created_at)')
                          ->orderBy('MONTH(created_at)','DESC');

        $data['registrations']=$eventRegistrationModel->select('DATE(created_at) as date,COUNT(*) as total')
                               ->groupBy('DATE(created_at)')
                               ->orderBy('DATE(created_at)','DESC');
        return view('admin/dashboard',$data);
    }
}

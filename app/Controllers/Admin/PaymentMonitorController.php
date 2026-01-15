<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PaymentModel;

class PaymentMonitorController extends BaseController{
    public function index(){
        $paymentModel=new PaymentModel();
        $payments=$paymentModel->select('payments.*,events.title as titlename,users.full_name as name')
        ->join('events','payments.event_id=events.id','left')
        ->join('users','payments.user_id=users.id','left')
        ->orderBy('payments.id','DESC')
        ->findAll();
        return view('admin/paymentmonitoring',[
            'payments'=>$payments
        ]);
    }
}
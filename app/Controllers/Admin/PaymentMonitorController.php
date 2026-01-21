<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PaymentModel;

class PaymentMonitorController extends BaseController{
    public function index(){
        $paymentModel=new PaymentModel();
        
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $date = $this->request->getGet('date');

        $query = $paymentModel->select('payments.*,events.title as titlename,users.full_name as name')
        ->join('events','payments.event_id=events.id','left')
        ->join('users','payments.user_id=users.id','left');
        
        if ($search) {
             $query->groupStart()
                  ->like('payments.transaction_id', $search)
                  ->orLike('users.full_name', $search)
                  ->orLike('events.title', $search)
                  ->groupEnd();
        }
        
        if ($status) {
            $query->where('payments.status', $status);
        }
        
        if ($date) {
             $dates = explode(' to ', $date);
            if (count($dates) == 2) {
                $query->where('date(payments.payment_date) >=', $dates[0])
                      ->where('date(payments.payment_date) <=', $dates[1]);
            } else {
                 $query->where('date(payments.payment_date)', $date);
            }
        }
        
        $payments = $query->orderBy('payments.id','DESC')->paginate(10);
        
        $data = [
            'payments' => $payments,
            'pager' => $paymentModel->pager,
            'search' => $search,
            'status' => $status,
            'date' => $date
        ];
        
        if ($this->request->isAJAX()) {
             return view('admin/partials/payments_table', $data);
        }
        
        return view('admin/paymentmonitoring', $data);
    }
}
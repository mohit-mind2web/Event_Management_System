<?php 
namespace App\Controllers\User;
use App\Models\EventModel;
use App\Models\PaymentModel;
use App\Controllers\BaseController;
class TransactionsController extends BaseController{
    public function index(){
        $userId=auth()->user()->id;
        $paymentModel=new PaymentModel();
        
        $query = $paymentModel->select('payments.*,events.title as event_title,events.id as event_id')
        ->join('events', 'payments.event_id = events.id')
        ->where('payments.user_id', $userId);

        // Filter: Status
        $status = $this->request->getGet('status');
        if (!empty($status)) {
            $query->where('payments.status', $status);
        }

        // Filter: Date
        $dateFilter = $this->request->getGet('date');
        if ($dateFilter === 'week') {
            $query->where('YEARWEEK(payments.created_at, 1)', date('YEARWEEK(CURDATE(), 1)'));
        } elseif ($dateFilter === 'month') {
            $query->where('MONTH(payments.created_at)', date('m'))
                  ->where('YEAR(payments.created_at)', date('Y'));
        }
        $transactions = $query->orderBy('payments.created_at','DESC')->paginate(2);
        
        $pager=$paymentModel->pager;
        
        $data = [
            'transactions'=>$transactions,
            'pager'=>$pager
        ];

        if ($this->request->isAJAX()) {
            return view('user/partials/transactions_list', $data);
        }

        return view('user/transactions', $data);
        }
}
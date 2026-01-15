<?php 
namespace App\Controllers\User;
use App\Models\EventModel;
use App\Models\PaymentModel;
use App\Controllers\BaseController;
class TransactionsController extends BaseController{
    public function index(){
        $userId=auth()->user()->id;
        // getting all transactions done by user
        $paymentModel=new PaymentModel();
        $paymentModel->select('payments.*,events.title as event_title,events.id as event_id')
        ->join('events', 'payments.event_id = events.id')
        ->where('payments.user_id', $userId);
        $transactions=$paymentModel->findAll();
        return view('user/transactions',[
            'transactions'=>$transactions
    ]);
        }
}
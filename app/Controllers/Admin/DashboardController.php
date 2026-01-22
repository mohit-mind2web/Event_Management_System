<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\PaymentModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $eventRegistrationModel = new EventRegistrationModel();
        $paymentModel = new PaymentModel();

        $userModel = new UserModel();
        $data['users'] = [
            'totalusers' => $userModel->join('auth_groups_users agu', 'users.id=agu.user_id')
                ->where('agu.group', 'user')->countAllResults(),
            'activeusers' => $userModel->join('auth_groups_users agu', 'users.id=agu.user_id')
                ->where('agu.group', 'user')->where('active', 1)->countAllResults(),
            'totalorganizers' => $userModel->join('auth_groups_users agu', 'users.id=agu.user_id')
                ->where('agu.group', 'organizer')->countAllResults(),

        ];
        $data['stats'] = [
            'totalevents' => $eventModel->countAll(),
            'totalregistrations' => $eventRegistrationModel->countAll(),
            'totalrevenue' => $paymentModel->select('SUM(amount) as total')
                ->where('status', 'success')
                ->first()['total'] ?? 0
        ];
        $data['events'] = [
            'approved' => $eventModel->where('status', 1)->countAllResults(),
            'pending' => $eventModel->where('status', 0)->countAllResults(),
            'rejected' => $eventModel->where('status', 2)->countAllResults()
        ];
        $data['payments'] = $paymentModel->select('MONTH(created_at) as month,SUM(amount) as totalamount')
            ->where('status', 'success')
            ->where('YEAR(created_at)', date('Y'))
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)', 'ASC')
            ->findAll();

        $data['registrations'] = $eventRegistrationModel->select('DATE(created_at) as date,COUNT(*) as total')
            ->where('created_at >=', date('Y-m-d', strtotime('-6 days')))
            ->groupBy('DATE(created_at)')
            ->orderBy('DATE(created_at)', 'ASC')
            ->findAll();
        return view('admin/dashboard', $data);
    }
}

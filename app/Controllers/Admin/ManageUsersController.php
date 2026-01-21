<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class ManageUsersController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        // We need to join with auth_identities to get email
        $query = $userModel->select('users.*, auth_identities.secret as email,auth_groups_users.group as role')
                           ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
                           ->where('auth_identities.type', 'email_password');

        if ($search) {
            $query->groupStart()
                  ->like('users.full_name', $search)
                  ->orLike('auth_identities.secret', $search)
                  ->groupEnd();
        }

        if ($status !== null && $status !== '') {
            if ($status == 'active') {
                $query->where('users.active', 1);
            } elseif ($status == 'banned') {
                $query->where('users.active', 0);
            }
        }
        $query->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
                  ->whereIn('auth_groups_users.group', ['user', 'organizer']);

        $users = $query->orderBy('users.created_at', 'DESC')->paginate(10);

        $data = [
            'users' => $users,
            'pager' => $userModel->pager,
            'search' => $search,
            'status' => $status
        ];

        if ($this->request->isAJAX()) {
            return view('admin/partials/manage_users_table', $data);
        }

        return view('admin/manage_users', $data);
    }

    public function toggleStatus($id)
    {
        $userModel = new UserModel();
        $user = $userModel->findById($id);

        if ($user) {
            $newStatus = !$user->active;
            
            // Toggle active status
            $user->active = $newStatus;
            $userModel->save($user);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User status updated successfully.',
                    'newStatus' => $newStatus,
                    'newStatusText' => $newStatus ? 'Active' : 'Blocked',
                    'newStatusClass' => $newStatus ? 'badge-success' : 'badge-danger',
                    'newBtnText' => $newStatus ? 'Block' : 'Unblock',
                    'newBtnClass' => $newStatus ? '#dc3545' : '#28a745',
                    'id' => $id
                ]);
            }
            
            return redirect()->back()->with('message', 'User status updated successfully.');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found.']);
        }

        return redirect()->back()->with('error', 'User not found.');
    }
}

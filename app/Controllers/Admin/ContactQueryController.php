<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactQueryModel;

class ContactQueryController extends BaseController
{
    public function index()
    {
        $contactModel = new ContactQueryModel();
        
        $status = $this->request->getGet('status');
        $email = $this->request->getGet('email');
        
        // Build Query
        if ($status !== null && $status !== '') {
            if ($status === 'pending') {
                $contactModel->where('status', 0);
            } elseif ($status === 'resolved') {
                $contactModel->where('status', 1);
            }
        }
        
        if (!empty($email)) {
            $contactModel->like('email', $email);
        }
        
        $data = [
            'queries' => $contactModel->orderBy('created_at', 'DESC')->paginate(10),
            'pager'   => $contactModel->pager,
            'filters' => [
                'status' => $status,
                'email'  => $email
            ]
        ];

        if ($this->request->isAJAX()) {
            return view('admin/partials/contact_queries_table', $data);
        }

        return view('admin/contact_queries', $data);
    }
    
    public function toggleStatus($id)
    {
        $contactModel = new ContactQueryModel();
        
        $query = $contactModel->find($id);
        
        if ($query) {
            $newStatus = ($query['status'] == 0) ? 1 : 0;
            $contactModel->update($id, ['status' => $newStatus]);
            
            if ($this->request->isAJAX()) {
                $isResolved = ($newStatus == 1);
                return $this->response->setJSON([
                    'success'        => true,
                    'message'        => 'Status updated successfully.',
                    'newStatus'      => $newStatus,
                    'newStatusText'  => $isResolved ? 'Resolved' : 'Pending',
                    'newStatusClass' => $isResolved ? 'bg-success' : 'bg-warning text-dark',
                    'newBtnText'     => $isResolved ? 'Mark Pending' : 'Mark Resolved',
                    'newBtnClass'    => $isResolved ? '#ffc107' : '#198754',
                    'id'             => $id
                ]);
            }

            return redirect()->back()->with('message', 'Status updated successfully.');
        }
        
        if ($this->request->isAJAX()) {
             return $this->response->setJSON(['success' => false, 'message' => 'Query not found.']);
        }

        return redirect()->back()->with('error', 'Query not found.');
    }
}

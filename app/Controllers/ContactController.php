<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContactQueryModel;

class ContactController extends BaseController
{
    public function index()
    {
        return view('contact');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'name'=> 'required|min_length[2]|max_length[255]',
        'email'   => 'required|valid_email|max_length[255]',
        'subject' => 'required|min_length[2]|max_length[255]',
        'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new ContactQueryModel();
        
        $data = [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
        ];

        if ($model->insert($data)) {
            return redirect()->to('/contact')->with('success', 'Your query has been submitted successfully. We will get back to you soon.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
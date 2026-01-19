<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;

class ProfileController extends BaseController{
    public function index($id){
        $userModel = model('UserModel');
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('user/home')->with('error', 'User not found.');
        }

        return view('user/profile', ['user' => $user]);
    }

    public function update($id)
    {
        $users = model('UserModel');
        $user = $users->find($id);

        if (!$user) {
             return redirect()->back()->with('error', 'User not found.');
        }

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
        ];
        
        // Ensure we are updating the current user
        if ($users->update($id, $data)) {
            return redirect()->to("user/profile/$id")->with('message', 'Profile updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update profile. Please try again.');
        }
    }
}

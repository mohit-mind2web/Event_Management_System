<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Entities\User;

class RegisterController extends ShieldRegister
{
    public function registerView()
    {
        return view('auth/register');
    }

    public function registerAction(): RedirectResponse
    {
        $rules = $this->getValidationRules();
        $rules['full_name'] = 'required|min_length[3]|max_length[255]';
        $rules['username']  = 'required|alpha_numeric|is_unique[users.username]';
        $rules['group']     = 'required|in_list[user,organizer]';
        
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = auth()->getProvider();

        // Create User Entity
        $user = new User([
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'active'    => true,
        ]);

        if (! $users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        //sending mail  using mail trap
        helper('email');
        send_welcome_email($user->email, $user->full_name, $user->username);
        $user = $users->findById($users->getInsertID()); 
        $role = $this->request->getPost('group');
        $user->addGroup($role);
        auth()->login($user);
        return redirect()->to(config('Auth')->loginRedirect());
    }
}

<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends ShieldLogin
{
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        return view('auth/login');
    }

    public function logoutAction(): RedirectResponse
    {
        auth()->logout();

        return redirect()->to(config('Auth')->logoutRedirect());
    }
}

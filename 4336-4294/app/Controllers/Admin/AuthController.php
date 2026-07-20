<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('admin/login');
    }

    public function processLogin()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->findByLogin($login);

        if (! $user || $user['password'] !== $password) {
            return redirect()->to('/admin/login')->with('error', 'Identifiants incorrects.');
        }

        session()->set([
            'admin_id' => $user['id'],
            'admin_nom' => $user['nom'],
            'admin_login' => $user['login'],
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->remove(['admin_id', 'admin_nom', 'admin_login']);
        return redirect()->to('/');
    }
}

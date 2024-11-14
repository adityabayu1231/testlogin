<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register()
    {
        $userModel = new UserModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $userModel->save([
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);

        $user = $userModel->where('email', $this->request->getVar('email'))->first();
        session()->set(['logged_in' => true, 'user_id' => $user['id']]);

        return $this->response->setJSON(['success' => 'Registration successful!', 'redirect' => '/dashboard']);
    }

    public function login()
    {
        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set(['logged_in' => true, 'user_id' => $user['id']]);
            return $this->response->setJSON(['success' => 'Login successful!', 'redirect' => '/dashboard']);
        }

        return $this->response->setJSON(['error' => 'Invalid username or password']);
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->route('/');
    }
}

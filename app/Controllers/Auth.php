<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // If already logged in, go to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return $this->login();
    }
    
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login');
    }
    
    public function doLogin()
{
    $model = new UserModel();
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    
    $user = $model->login($username, $password);
    
    if ($user) {
        session()->set([
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'fullname'  => $user['fullname'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);
        
        // Redirect based on role
        if ($user['role'] === 'staff') {
            return redirect()->to('/pos');
        } else {
            return redirect()->to('/dashboard');
        }
    }
    
    session()->setFlashdata('error', 'Invalid username or password');
    return redirect()->to('/login');
}
    
    public function doRegister()
    {
        $model = new UserModel();
        
        $existing = $model->where('username', $this->request->getPost('username'))->first();
        if ($existing) {
            session()->setFlashdata('error', 'Username already exists!');
            return redirect()->to('/register');
        }
        
        // First user becomes admin, others become staff
        $userCount = $model->countAll();
        $role = ($userCount == 0) ? 'admin' : 'staff';
        
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => md5($this->request->getPost('password')),
            'fullname' => $this->request->getPost('fullname'),
            'role'     => $role
        ];
        
        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/login');
        }
        
        session()->setFlashdata('error', 'Registration failed!');
        return redirect()->to('/register');
    }
    
    // FIXED: Logout method
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
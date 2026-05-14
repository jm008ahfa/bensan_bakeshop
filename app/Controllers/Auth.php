<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'staff') {
                return redirect()->to('/pos');
            }
            return redirect()->to('/dashboard');
        }
        return $this->login();
    }
    
    public function login()
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'staff') {
                return redirect()->to('/pos');
            }
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }
    
    public function doLogin()
    {
        $db = \Config\Database::connect();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $query = $db->query("SELECT * FROM users WHERE username = ? AND password = MD5(?)", [$username, $password]);
        $user = $query->getRowArray();
        
        if ($user) {
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'fullname'  => $user['fullname'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);
            
            if ($user['role'] === 'staff') {
                return redirect()->to('/pos');
            }
            return redirect()->to('/dashboard');
        }
        
        session()->setFlashdata('error', 'Invalid username or password');
        return redirect()->to('/login');
    }
    
    // ============================================
    // SIMPLE REGISTRATION - REWRITTEN
    // ============================================
    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register');
    }
    
    public function doRegister()
    {
        // Get POST data
        $fullname = $this->request->getPost('fullname');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Basic validation
        if (empty($fullname) || empty($username) || empty($password)) {
            session()->setFlashdata('message', 'All fields are required');
            session()->setFlashdata('message_type', 'error');
            return redirect()->to('/register');
        }
        
        if (strlen($password) < 6) {
            session()->setFlashdata('message', 'Password must be at least 6 characters');
            session()->setFlashdata('message_type', 'error');
            return redirect()->to('/register');
        }
        
        $db = \Config\Database::connect();
        
        // Check if username exists
        $check = $db->query("SELECT COUNT(*) as count FROM users WHERE username = ?", [$username]);
        $result = $check->getRow();
        
        if ($result->count > 0) {
            session()->setFlashdata('message', 'Username already exists! Please choose another.');
            session()->setFlashdata('message_type', 'error');
            return redirect()->to('/register');
        }
        
        // Get user count to determine role
        $countQuery = $db->query("SELECT COUNT(*) as total FROM users");
        $countResult = $countQuery->getRow();
        $userCount = $countResult->total;
        $role = ($userCount == 0) ? 'admin' : 'staff';
        
        // Insert new user
        $insert = $db->query("INSERT INTO users (username, password, fullname, role) VALUES (?, MD5(?), ?, ?)", 
            [$username, $password, $fullname, $role]);
        
        if ($insert) {
            session()->setFlashdata('message', 'Registration successful! Please login.');
            session()->setFlashdata('message_type', 'success');
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('message', 'Registration failed. Please try again.');
            session()->setFlashdata('message_type', 'error');
            return redirect()->to('/register');
        }
    }
    // ============================================
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
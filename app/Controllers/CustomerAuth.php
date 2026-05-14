<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerAuth extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }
    
    // THIS INDEX METHOD IS CRUCIAL - IT HANDLES /customer
    public function index()
    {
        // If already logged in, go to store
        if (session()->get('customer_logged_in')) {
            return redirect()->to('/customer/store');
        }
        // Otherwise show login page
        return redirect()->to('/customer/login');
    }
    
    public function login()
    {
        if (session()->get('customer_logged_in')) {
            return redirect()->to('/customer/store');
        }
        return view('customer/auth/login');
    }
    
    public function doLogin()
    {
        $model = new CustomerModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $customer = $model->where('email', $email)->first();
        
        if ($customer && password_verify($password, $customer['password'])) {
            session()->set([
                'customer_id' => $customer['id'],
                'customer_name' => $customer['name'],
                'customer_email' => $customer['email'],
                'customer_phone' => $customer['phone'],
                'customer_address' => $customer['address'],
                'customer_logged_in' => true
            ]);
            return redirect()->to('/customer/store');
        }
        
        session()->setFlashdata('error', 'Invalid email or password');
        return redirect()->to('/customer/login');
    }
    
    public function register()
    {
        if (session()->get('customer_logged_in')) {
            return redirect()->to('/customer/store');
        }
        return view('customer/auth/register');
    }
    
    public function doRegister()
    {
        $model = new CustomerModel();
        
        $existing = $model->where('email', $this->request->getPost('email'))->first();
        if ($existing) {
            session()->setFlashdata('error', 'Email already registered!');
            return redirect()->to('/customer/register');
        }
        
        if ($this->request->getPost('password') !== $this->request->getPost('confirm_password')) {
            session()->setFlashdata('error', 'Passwords do not match!');
            return redirect()->to('/customer/register');
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/customer/login');
        }
        
        session()->setFlashdata('error', 'Registration failed!');
        return redirect()->to('/customer/register');
    }
    
    public function dashboard()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('/customer/login');
        }
        
        $db = \Config\Database::connect();
        $orders = $db->table('orders')
                     ->where('customer_email', session()->get('customer_email'))
                     ->orderBy('order_date', 'DESC')
                     ->get()
                     ->getResultArray();
        
        return view('customer/store_template', [
            'title' => 'My Dashboard',
            'content' => view('customer/dashboard', ['orders' => $orders])
        ]);
    }
    
    public function myAccount()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('/customer/login');
        }
        
        $db = \Config\Database::connect();
        $orders = $db->table('orders')
                     ->where('customer_email', session()->get('customer_email'))
                     ->orderBy('order_date', 'DESC')
                     ->get()
                     ->getResultArray();
        
        return view('customer/store_template', [
            'title' => 'My Account',
            'content' => view('customer/my_account', ['orders' => $orders])
        ]);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/customer/login');
    }
}
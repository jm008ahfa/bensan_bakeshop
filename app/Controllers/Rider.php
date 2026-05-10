<?php

namespace App\Controllers;

use App\Models\RiderModel;
use App\Models\OrderModel;

class Rider extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }
    
    public function index()
    {
        return $this->login();
    }
    
    public function login()
    {
        if (session()->get('rider_logged_in')) {
            return redirect()->to('/rider/dashboard');
        }
        return view('rider/login');
    }
    
    public function doLogin()
    {
        $model = new RiderModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $rider = $model->where('email', $email)->first();
        
        if ($rider && $rider['password'] === md5($password)) {
            session()->set([
                'rider_id' => $rider['id'],
                'rider_name' => $rider['name'],
                'rider_email' => $rider['email'],
                'rider_logged_in' => true
            ]);
            return redirect()->to('/rider/dashboard');
        }
        
        session()->setFlashdata('error', 'Invalid credentials');
        return redirect()->to('/rider/login');
    }
    
    // ============================================
    // REGISTER METHODS - ADD THESE
    // ============================================
    public function register()
    {
        if (session()->get('rider_logged_in')) {
            return redirect()->to('/rider/dashboard');
        }
        return view('rider/register');
    }
    
    public function doRegister()
    {
        $model = new RiderModel();
        
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[riders.email]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'vehicle_type' => 'required',
            'plate_number' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->to('/rider/register')->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'vehicle_type' => $this->request->getPost('vehicle_type'),
            'plate_number' => strtoupper($this->request->getPost('plate_number')),
            'password' => md5($this->request->getPost('password')),
            'status' => 'available',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/rider/login');
        }
        
        session()->setFlashdata('error', 'Registration failed. Please try again.');
        return redirect()->to('/rider/register');
    }
    // ============================================
    // END OF REGISTER METHODS
    // ============================================
    
    public function dashboard()
    {
        if (!session()->get('rider_logged_in')) {
            return redirect()->to('/rider/login');
        }
        
        $db = \Config\Database::connect();
        
        $readyOrders = $db->table('orders')
                          ->select('orders.*')
                          ->where('orders.delivery_status', 'ready')
                          ->where('orders.order_type', 'online')
                          ->orderBy('orders.order_date', 'ASC')
                          ->get()
                          ->getResultArray();
        
        $myDeliveries = $db->table('orders')
                           ->select('orders.*')
                           ->where('orders.rider_id', session()->get('rider_id'))
                           ->where('orders.delivery_status', 'assigned')
                           ->orderBy('orders.order_date', 'ASC')
                           ->get()
                           ->getResultArray();
        
        $completedDeliveries = $db->table('orders')
                                  ->select('orders.*')
                                  ->where('orders.rider_id', session()->get('rider_id'))
                                  ->where('orders.delivery_status', 'delivered')
                                  ->orderBy('orders.delivered_at', 'DESC')
                                  ->limit(50)
                                  ->get()
                                  ->getResultArray();
        
        foreach($readyOrders as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        foreach($myDeliveries as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        foreach($completedDeliveries as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        $data = [
            'readyOrders' => $readyOrders,
            'myDeliveries' => $myDeliveries,
            'completedDeliveries' => $completedDeliveries
        ];
        
        return view('rider/template', [
            'title' => 'Rider Dashboard',
            'content' => view('rider/dashboard', $data)
        ]);
    }
    
    public function acceptOrder($order_id)
    {
        if (!session()->get('rider_logged_in')) {
            return redirect()->to('/rider/login');
        }
        
        $db = \Config\Database::connect();
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/rider/dashboard');
        }
        
        if ($order['delivery_status'] != 'ready') {
            session()->setFlashdata('error', 'Order is no longer available');
            return redirect()->to('/rider/dashboard');
        }
        
        $updateData = [
            'rider_id' => session()->get('rider_id'),
            'rider_name' => session()->get('rider_name'),
            'delivery_status' => 'assigned',
            'confirmed_by_rider_at' => date('Y-m-d H:i:s'),
            'estimated_delivery_time' => date('Y-m-d H:i:s', strtotime('+30 minutes'))
        ];
        
        if ($orderModel->update($order_id, $updateData)) {
            $db->table('riders')->where('id', session()->get('rider_id'))->update(['status' => 'busy']);
            session()->setFlashdata('success', 'Order accepted! Please deliver within 30 minutes.');
        } else {
            session()->setFlashdata('error', 'Failed to accept order');
        }
        
        return redirect()->to('/rider/dashboard');
    }
    
    public function deliverOrder($order_id)
    {
        if (!session()->get('rider_logged_in')) {
            return redirect()->to('/rider/login');
        }
        
        $db = \Config\Database::connect();
        
        $order = $db->table('orders')
                    ->where('id', $order_id)
                    ->get()
                    ->getRowArray();
        
        if (!$order || $order['rider_id'] != session()->get('rider_id')) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/rider/dashboard');
        }
        
        $items = $db->table('order_items')
                    ->select('order_items.*, products.name as product_name')
                    ->join('products', 'products.id = order_items.product_id')
                    ->where('order_items.order_id', $order_id)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'order' => $order,
            'items' => $items
        ];
        
        return view('rider/template', [
            'title' => 'Confirm Delivery',
            'content' => view('rider/delivery_form', $data)
        ]);
    }
    
    public function processDelivery()
    {
        if (!session()->get('rider_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }
        
        $order_id = $this->request->getPost('order_id');
        $delivery_notes = $this->request->getPost('delivery_notes');
        
        $orderModel = new OrderModel();
        $db = \Config\Database::connect();
        
        $order = $orderModel->find($order_id);
        
        if (!$order || $order['rider_id'] != session()->get('rider_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Order not found']);
        }
        
        $photoName = null;
        $file = $this->request->getFile('delivery_photo');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = 'uploads/delivery_proof';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $photoName = 'delivery_' . $order['order_number'] . '_' . time() . '.' . $file->getExtension();
            $file->move($uploadPath, $photoName);
        }
        
        $updateData = [
            'delivery_status' => 'delivered',
            'status' => 'completed',
            'delivered_at' => date('Y-m-d H:i:s'),
            'delivery_notes' => $delivery_notes,
            'delivery_photo' => $photoName,
            'delivered_by_name' => session()->get('rider_name')
        ];
        
        if ($orderModel->update($order_id, $updateData)) {
            $db->table('riders')->where('id', session()->get('rider_id'))->update(['status' => 'available']);
            return $this->response->setJSON(['success' => true, 'message' => 'Delivery confirmed!']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to confirm delivery']);
    }
    
    public function viewOrder($order_id)
    {
        if (!session()->get('rider_logged_in')) {
            return redirect()->to('/rider/login');
        }
        
        $db = \Config\Database::connect();
        
        $order = $db->table('orders')
                    ->where('id', $order_id)
                    ->get()
                    ->getRowArray();
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/rider/dashboard');
        }
        
        $items = $db->table('order_items')
                    ->select('order_items.*, products.name as product_name')
                    ->join('products', 'products.id = order_items.product_id')
                    ->where('order_items.order_id', $order_id)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'order' => $order,
            'items' => $items
        ];
        
        return view('rider/template', [
            'title' => 'Order Details',
            'content' => view('rider/order_detail', $data)
        ]);
    }
    
    public function logout()
    {
        if (session()->get('rider_id')) {
            $db = \Config\Database::connect();
            $db->table('riders')->where('id', session()->get('rider_id'))->update(['status' => 'offline']);
        }
        session()->destroy();
        return redirect()->to('/rider/login');
    }
}
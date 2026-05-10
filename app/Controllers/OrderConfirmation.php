<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderConfirmation extends BaseController
{
    public function __construct()
    {
        if (!session()->get('logged_in')) {
            redirect()->to('/login');
        }
    }
    
    public function pending()
    {
        $db = \Config\Database::connect();
        
        $orders = $db->table('orders')
                     ->select('orders.*, COUNT(order_items.id) as item_count')
                     ->join('order_items', 'order_items.order_id = orders.id', 'left')
                     ->where('orders.order_type', 'online')
                     ->where('orders.status', 'pending')
                     ->groupBy('orders.id')
                     ->orderBy('orders.order_date', 'ASC')
                     ->get()
                     ->getResultArray();
        
        foreach($orders as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        $data = ['orders' => $orders];
        
        return view('template', [
            'title' => 'Pending Orders',
            'active_menu' => 'pending_orders',
            'content' => view('order_confirmation/pending', $data)
        ]);
    }
    
    public function confirm($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/pending');
        }
        
        // FIXED: Only update if status is different
        if ($order['status'] != 'preparing') {
            $result = $orderModel->update($order_id, ['status' => 'preparing']);
            
            if ($result) {
                session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' has been confirmed and is now preparing!');
            } else {
                session()->setFlashdata('error', 'Failed to confirm order');
            }
        } else {
            session()->setFlashdata('info', 'Order is already in preparing status');
        }
        
        return redirect()->to('/order-confirmation/preparing');
    }
    
    public function preparing()
    {
        $db = \Config\Database::connect();
        
        $orders = $db->table('orders')
                     ->select('orders.*, COUNT(order_items.id) as item_count')
                     ->join('order_items', 'order_items.order_id = orders.id', 'left')
                     ->where('orders.order_type', 'online')
                     ->where('orders.status', 'preparing')
                     ->groupBy('orders.id')
                     ->orderBy('orders.order_date', 'DESC')
                     ->get()
                     ->getResultArray();
        
        foreach($orders as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        $data = ['orders' => $orders];
        
        return view('template', [
            'title' => 'Preparing Orders',
            'active_menu' => 'preparing_orders',
            'content' => view('order_confirmation/preparing', $data)
        ]);
    }
    
    // FIXED: Mark ready method
    public function markReady($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/preparing');
        }
        
        // Check if already ready
        if ($order['status'] == 'ready') {
            session()->setFlashdata('info', 'Order is already marked as ready');
            return redirect()->to('/order-confirmation/ready');
        }
        
        // Update status to ready
        $result = $orderModel->update($order_id, ['status' => 'ready']);
        
        if ($result) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' is now ready!');
        } else {
            session()->setFlashdata('error', 'Failed to update order status');
        }
        
        return redirect()->to('/order-confirmation/ready');
    }
    
    // FIXED: Mark ready for rider
    public function markReadyForRider($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/ready');
        }
        
        // Check if already ready for rider
        if ($order['delivery_status'] == 'ready') {
            session()->setFlashdata('info', 'Order is already marked as ready for rider');
            return redirect()->to('/order-confirmation/ready');
        }
        
        // Update delivery_status to 'ready' - THIS IS WHAT RIDER LOOKS FOR
        $result = $orderModel->update($order_id, ['delivery_status' => 'ready']);
        
        if ($result) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' is now ready for rider pickup!');
        } else {
            session()->setFlashdata('error', 'Failed to update order status');
        }
        
        return redirect()->to('/order-confirmation/ready');
    }
    
    public function ready()
{
    $db = \Config\Database::connect();
    
    // Get orders that are ready (status = 'ready')
    $orders = $db->table('orders')
                 ->select('orders.*, COUNT(order_items.id) as item_count')
                 ->join('order_items', 'order_items.order_id = orders.id', 'left')
                 ->where('orders.order_type', 'online')
                 ->where('orders.status', 'ready')
                 ->groupBy('orders.id')
                 ->orderBy('orders.order_date', 'DESC')
                 ->get()
                 ->getResultArray();
    
    foreach($orders as &$order) {
        $items = $db->table('order_items')
                    ->select('order_items.*, products.name as product_name')
                    ->join('products', 'products.id = order_items.product_id')
                    ->where('order_items.order_id', $order['id'])
                    ->get()
                    ->getResultArray();
        $order['items'] = $items;
        
        // If assigned, get rider name
        if($order['delivery_status'] == 'assigned' && $order['rider_id']) {
            $rider = $db->table('riders')
                        ->select('name')
                        ->where('id', $order['rider_id'])
                        ->get()
                        ->getRowArray();
            $order['rider_name'] = $rider['name'] ?? 'Unknown Rider';
        }
    }
    
    $data = ['orders' => $orders];
    
    return view('template', [
        'title' => 'Ready Orders',
        'active_menu' => 'ready_orders',
        'content' => view('order_confirmation/ready', $data)
    ]);
}
    
    // FIXED: Mark completed method
    public function markCompleted($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/ready');
        }
        
        // Check if already completed
        if ($order['status'] == 'completed') {
            session()->setFlashdata('info', 'Order is already completed');
            return redirect()->to('/order-confirmation/completed');
        }
        
        $result = $orderModel->update($order_id, ['status' => 'completed']);
        
        if ($result) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' has been completed!');
        } else {
            session()->setFlashdata('error', 'Failed to update order status');
        }
        
        return redirect()->to('/order-confirmation/completed');
    }
    
    public function completed()
    {
        $db = \Config\Database::connect();
        
        $orders = $db->table('orders')
                     ->select('orders.*, COUNT(order_items.id) as item_count')
                     ->join('order_items', 'order_items.order_id = orders.id', 'left')
                     ->where('orders.order_type', 'online')
                     ->where('orders.status', 'completed')
                     ->groupBy('orders.id')
                     ->orderBy('orders.order_date', 'DESC')
                     ->limit(50)
                     ->get()
                     ->getResultArray();
        
        foreach($orders as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        $data = ['orders' => $orders];
        
        return view('template', [
            'title' => 'Completed Orders',
            'active_menu' => 'completed_orders',
            'content' => view('order_confirmation/completed', $data)
        ]);
    }
    
    public function cancel($order_id)
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $db = \Config\Database::connect();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/pending');
        }
        
        // Restore stock
        $items = $db->table('order_items')
                    ->where('order_id', $order_id)
                    ->get()
                    ->getResultArray();
        
        foreach($items as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $new_stock = $product['stock'] + $item['quantity'];
                $productModel->update($item['product_id'], ['stock' => $new_stock]);
            }
        }
        
        $result = $orderModel->update($order_id, ['status' => 'cancelled', 'delivery_status' => 'cancelled']);
        
        if ($result) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' has been cancelled.');
        } else {
            session()->setFlashdata('error', 'Failed to cancel order');
        }
        
        return redirect()->to('/order-confirmation/pending');
    }
    
    public function view($order_id)
{
    $db = \Config\Database::connect();
    $orderModel = new OrderModel();
    
    $order = $orderModel->find($order_id);
    
    if (!$order) {
        session()->setFlashdata('error', 'Order not found');
        return redirect()->to('/order-confirmation/pending');
    }
    
    // Get order items
    $items = $db->table('order_items')
                ->select('order_items.*, products.name as product_name')
                ->join('products', 'products.id = order_items.product_id')
                ->where('order_items.order_id', $order_id)
                ->get()
                ->getResultArray();
    
    // Get rider information if assigned
    if(isset($order['rider_id']) && $order['rider_id']) {
        $rider = $db->table('riders')
                    ->select('name, phone, vehicle_type, plate_number')
                    ->where('id', $order['rider_id'])
                    ->get()
                    ->getRowArray();
        if($rider) {
            $order['rider_phone'] = $rider['phone'] ?? 'N/A';
            $order['rider_vehicle'] = $rider['vehicle_type'] ?? 'N/A';
            $order['rider_plate'] = $rider['plate_number'] ?? 'N/A';
        }
    }
    
    $data = [
        'order' => $order,
        'items' => $items
    ];
    
    return view('template', [
        'title' => 'Order Details',
        'active_menu' => 'pending_orders',
        'content' => view('order_confirmation/view', $data)
    ]);
}
}
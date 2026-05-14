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
    
    // Confirm order - moves from pending to preparing
    public function confirm($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/pending');
        }
        
        $updateData = [
            'status' => 'preparing',
            'delivery_status' => 'preparing'
        ];
        
        if ($orderModel->update($order_id, $updateData)) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' is now being prepared!');
        } else {
            session()->setFlashdata('error', 'Failed to confirm order');
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
    
    // Mark order as ready (admin marks order ready for pickup)
    public function markReady($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/preparing');
        }
        
        $updateData = [
            'status' => 'ready'
        ];
        
        if ($orderModel->update($order_id, $updateData)) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' is now ready!');
        } else {
            session()->setFlashdata('error', 'Failed to update order status');
        }
        
        return redirect()->to('/order-confirmation/ready');
    }
    
    // CRITICAL: Mark order as ready for rider pickup - THIS IS WHAT RIDER SEES
    public function markReadyForRider($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/ready');
        }
        
        // THIS SETS delivery_status TO 'ready' - RIDER LOOKS FOR THIS
        $updateData = [
            'delivery_status' => 'ready'
        ];
        
        if ($orderModel->update($order_id, $updateData)) {
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
        }
        
        $data = ['orders' => $orders];
        
        return view('template', [
            'title' => 'Ready Orders',
            'active_menu' => 'ready_orders',
            'content' => view('order_confirmation/ready', $data)
        ]);
    }
    
    public function completed()
{
    $db = \Config\Database::connect();
    
    // Get ALL completed orders (both from admin and rider)
    $orders = $db->table('orders')
                 ->select('orders.*, COUNT(order_items.id) as item_count')
                 ->join('order_items', 'order_items.order_id = orders.id', 'left')
                 ->where('orders.order_type', 'online')
                 ->where('orders.status', 'completed')
                 ->groupBy('orders.id')
                 ->orderBy('orders.order_date', 'DESC')
                 ->limit(100)
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
        
        // Get rider info if assigned
        if(isset($order['rider_id']) && $order['rider_id']) {
            $rider = $db->table('riders')
                        ->select('name, phone')
                        ->where('id', $order['rider_id'])
                        ->get()
                        ->getRowArray();
            if($rider) {
                $order['rider_name'] = $rider['name'];
            }
        }
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
        
        if ($orderModel->update($order_id, ['status' => 'cancelled', 'delivery_status' => 'cancelled'])) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' has been cancelled.');
        } else {
            session()->setFlashdata('error', 'Failed to cancel order');
        }
        
        return redirect()->to('/order-confirmation/pending');
    }
    
    public function markCompleted($order_id)
    {
        $orderModel = new OrderModel();
        
        $order = $orderModel->find($order_id);
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found');
            return redirect()->to('/order-confirmation/ready');
        }
        
        if ($orderModel->update($order_id, ['status' => 'completed'])) {
            session()->setFlashdata('success', 'Order #' . $order['order_number'] . ' has been completed!');
        } else {
            session()->setFlashdata('error', 'Failed to update order status');
        }
        
        return redirect()->to('/order-confirmation/completed');
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
        
        return view('template', [
            'title' => 'Order Details',
            'active_menu' => 'pending_orders',
            'content' => view('order_confirmation/view', $data)
        ]);
    }
}
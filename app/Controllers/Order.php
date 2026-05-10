<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;

class Order extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $db = \Config\Database::connect();
        
        $orders = $orderModel->orderBy('order_date', 'DESC')->findAll();
        
        foreach($orders as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
            $order['item_count'] = count($items);
            
            $product_names = array_column($items, 'product_name');
            $order['product_summary'] = implode(', ', $product_names);
        }
        
        $data = ['orders' => $orders];
        
        return view('template', [
            'title' => 'Orders',
            'active_menu' => 'orders',
            'content' => view('order/index', $data)
        ]);
    }
    
    public function create()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        
        return view('template', [
            'title' => 'New Order',
            'active_menu' => 'orders',
            'content' => view('order/create', $data)
        ]);
    }
    
    public function store()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $db = \Config\Database::connect();
        
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        $customer_name = $this->request->getPost('customer_name');
        $order_type = $this->request->getPost('order_type');
        
        $product = $productModel->find($product_id);
        
        if (!$product) {
            session()->setFlashdata('error', 'Product not found!');
            return redirect()->to('/order/create');
        }
        
        if ($product['stock'] < $quantity) {
            session()->setFlashdata('error', 'Insufficient stock! Only ' . $product['stock'] . ' available.');
            return redirect()->to('/order/create');
        }
        
        $total = $product['price'] * $quantity;
        $order_number = $orderModel->generateOrderNumber();
        
        $db->transStart();
        
        $orderData = [
            'order_number' => $order_number,
            'customer_name' => $customer_name,
            'order_type' => $order_type,
            'total' => $total,
            'status' => 'completed'
        ];
        
        $orderModel->insert($orderData);
        $order_id = $orderModel->getInsertID();
        
        $db->table('order_items')->insert([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $product['price']
        ]);
        
        $new_stock = $product['stock'] - $quantity;
        $productModel->update($product_id, ['stock' => $new_stock]);
        
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Failed to create order!');
        } else {
            session()->setFlashdata('success', 'Order #' . $order_number . ' created successfully!');
        }
        
        return redirect()->to('/orders');
    }
    
    // FIXED: View order method
    public function view($id)
    {
        $db = \Config\Database::connect();
        
        // Get order details
        $order = $db->table('orders')
                    ->where('id', $id)
                    ->get()
                    ->getRowArray();
        
        if (!$order) {
            session()->setFlashdata('error', 'Order not found!');
            return redirect()->to('/orders');
        }
        
        // Get order items with product details
        $items = $db->table('order_items')
                    ->select('order_items.*, products.name as product_name')
                    ->join('products', 'products.id = order_items.product_id')
                    ->where('order_items.order_id', $id)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'order' => $order,
            'items' => $items
        ];
        
        return view('template', [
            'title' => 'Order Details',
            'active_menu' => 'orders',
            'content' => view('order/view', $data)
        ]);
    }
    
    public function delete($id)
    {
        $orderModel = new OrderModel();
        $db = \Config\Database::connect();
        
        $items = $db->table('order_items')->where('order_id', $id)->get()->getResultArray();
        
        $productModel = new ProductModel();
        foreach($items as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $new_stock = $product['stock'] + $item['quantity'];
                $productModel->update($item['product_id'], ['stock' => $new_stock]);
            }
        }
        
        $db->table('order_items')->where('order_id', $id)->delete();
        
        if ($orderModel->delete($id)) {
            session()->setFlashdata('success', 'Order deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to delete order!');
        }
        
        return redirect()->to('/orders');
    }
}
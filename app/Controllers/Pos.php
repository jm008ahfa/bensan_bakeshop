<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;

class Pos extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll();
        
        // Add image URL to each product
        foreach($products as &$product) {
            if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                $product['image_url'] = base_url('uploads/products/' . $product['image']);
            } else {
                $product['image_url'] = base_url('assets/images/default-product.png');
            }
        }
        
        $data = [
            'products' => $products,
            'title' => 'Point of Sale',
            'active_menu' => 'pos'
        ];
        
        return view('template', [
            'title' => 'Point of Sale',
            'active_menu' => 'pos',
            'content' => view('pos/index', $data)
        ]);
    }
    
    public function processOrder()
    {
        $cart = json_decode($this->request->getPost('cart'), true);
        $customer_name = $this->request->getPost('customer_name') ?: 'Walk-in Customer';
        $order_type = $this->request->getPost('order_type') ?: 'walk_in';
        
        if (empty($cart)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cart is empty']);
        }
        
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $db = \Config\Database::connect();
        
        $total_amount = 0;
        $order_items = [];
        
        foreach($cart as $item) {
            $product = $productModel->find($item['id']);
            if (!$product) {
                return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
            }
            if ($product['stock'] < $item['quantity']) {
                return $this->response->setJSON(['success' => false, 'message' => 'Insufficient stock for ' . $product['name']]);
            }
            $subtotal = $product['price'] * $item['quantity'];
            $total_amount += $subtotal;
            $order_items[] = [
                'name' => $product['name'],
                'quantity' => $item['quantity'],
                'price' => $product['price'],
                'subtotal' => $subtotal
            ];
        }
        
        $order_number = 'POS-' . date('Ymd') . '-' . rand(100, 999);
        
        $db->transStart();
        
        $orderData = [
            'order_number' => $order_number,
            'customer_name' => $customer_name,
            'order_type' => $order_type,
            'total' => $total_amount,
            'status' => 'completed'
        ];
        
        $orderModel->insert($orderData);
        $order_id = $orderModel->getInsertID();
        
        foreach($cart as $item) {
            $product = $productModel->find($item['id']);
            $db->table('order_items')->insert([
                'order_id' => $order_id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $product['price']
            ]);
            $new_stock = $product['stock'] - $item['quantity'];
            $productModel->update($item['id'], ['stock' => $new_stock]);
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaction failed']);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Order completed!',
            'order_number' => $order_number,
            'total' => $total_amount,
            'receipt' => [
                'order_number' => $order_number,
                'customer_name' => $customer_name,
                'order_type' => $order_type,
                'order_date' => date('F d, Y h:i A'),
                'items' => $order_items,
                'total' => $total_amount,
                'cashier' => session()->get('fullname')
            ]
        ]);
    }
}
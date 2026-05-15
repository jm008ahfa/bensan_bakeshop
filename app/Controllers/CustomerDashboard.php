<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;

class CustomerDashboard extends BaseController
{
    // Public - No login required to view
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        $products = $productModel->findAll();
        foreach($products as &$product) {
            if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                $product['image_url'] = base_url('uploads/products/' . $product['image']);
            } else {
                $product['image_url'] = base_url('assets/images/default-product.png');
            }
        }
        
        $categories = $categoryModel->findAll();
        
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        
        return view('customer/public_template', [
            'title' => 'Bensan Bakeshop',
            'content' => view('customer/index', $data)
        ]);
    }
    
    public function products()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        $products = $productModel->findAll();
        foreach($products as &$product) {
            if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                $product['image_url'] = base_url('uploads/products/' . $product['image']);
            } else {
                $product['image_url'] = base_url('assets/images/default-product.png');
            }
        }
        
        $data = [
            'products' => $products,
            'categories' => $categoryModel->findAll()
        ];
        
        return view('customer/public_template', [
            'title' => 'All Products',
            'content' => view('customer/products', $data)
        ]);
    }
    
    public function productDetail($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);
        
        if(!$product) {
            return redirect()->to('/customer');
        }
        
        if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
            $product['image_url'] = base_url('uploads/products/' . $product['image']);
        } else {
            $product['image_url'] = base_url('assets/images/default-product.png');
        }
        
        $related = [];
        if($product['category_id']) {
            $related = $productModel->where('category_id', $product['category_id'])
                                    ->where('id !=', $id)
                                    ->findAll(4);
            foreach($related as &$r) {
                if(!empty($r['image']) && file_exists('uploads/products/' . $r['image'])) {
                    $r['image_url'] = base_url('uploads/products/' . $r['image']);
                } else {
                    $r['image_url'] = base_url('assets/images/default-product.png');
                }
            }
        }
        
        return view('customer/public_template', [
            'title' => $product['name'],
            'content' => view('customer/product_detail', ['product' => $product, 'related' => $related])
        ]);
    }
    
    public function category($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        $category = $categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/customer');
        }
        
        $products = $productModel->where('category_id', $id)->findAll();
        
        foreach($products as &$product) {
            if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                $product['image_url'] = base_url('uploads/products/' . $product['image']);
            } else {
                $product['image_url'] = base_url('assets/images/default-product.png');
            }
        }
        
        $data = [
            'products' => $products,
            'category' => $category
        ];
        
        return view('customer/public_template', [
            'title' => $category['name'],
            'content' => view('customer/category_products', $data)
        ]);
    }
    
    // ============================================
    // CHECKOUT - REQUIRES LOGIN
    // ============================================
    public function checkout()
    {
        if (!session()->get('customer_logged_in')) {
            session()->setFlashdata('error', 'Please login or create an account to continue');
            return redirect()->to('/customer/login');
        }
        
        return view('customer/public_template', [
            'title' => 'Checkout',
            'content' => view('customer/checkout')
        ]);
    }
    
    public function placeOrder()
    {
        if (!session()->get('customer_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Please login to place order']);
        }
        
        $cart = json_decode($this->request->getPost('cart'), true);
        $customer_name = $this->request->getPost('customer_name');
        $customer_email = $this->request->getPost('customer_email');
        $customer_phone = $this->request->getPost('customer_phone');
        $delivery_address = $this->request->getPost('delivery_address');
        $payment_method = $this->request->getPost('payment_method') ?: 'cod';
        
        if (empty($cart)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cart is empty']);
        }
        
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $db = \Config\Database::connect();
        
        $total_amount = 0;
        
        foreach($cart as $item) {
            $product = $productModel->find($item['id']);
            if (!$product) {
                return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
            }
            if ($product['stock'] < $item['quantity']) {
                return $this->response->setJSON(['success' => false, 'message' => 'Insufficient stock for ' . $product['name']]);
            }
            $total_amount += $product['price'] * $item['quantity'];
        }
        
        $order_number = 'ORD-' . date('Ymd') . '-' . rand(100, 999);
        
        $db->transStart();
        
        $orderData = [
            'order_number' => $order_number,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'delivery_address' => $delivery_address,
            'order_type' => 'online',
            'payment_method' => $payment_method,
            'payment_status' => 'pending',
            'total' => $total_amount,
            'status' => 'pending',
            'delivery_status' => 'pending',
            'order_date' => date('Y-m-d H:i:s')
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
            'message' => 'Order placed successfully!',
            'order_number' => $order_number,
            'total' => $total_amount
        ]);
    }
    
    public function trackOrder()
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
        
        foreach($orders as &$order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
            
            if(isset($order['rider_id']) && $order['rider_id']) {
                $rider = $db->table('riders')
                            ->select('name, phone')
                            ->where('id', $order['rider_id'])
                            ->get()
                            ->getRowArray();
                if($rider) {
                    $order['rider_name'] = $rider['name'];
                    $order['rider_phone'] = $rider['phone'];
                }
            }
        }
        
        return view('customer/public_template', [
            'title' => 'Track Orders',
            'content' => view('customer/track_order', ['orders' => $orders])
        ]);
    }
    
    public function viewOrder($order_number)
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('/customer/login');
        }
        
        $db = \Config\Database::connect();
        
        $order = $db->table('orders')
                    ->where('order_number', $order_number)
                    ->get()
                    ->getRowArray();
        
        if (!$order || $order['customer_email'] != session()->get('customer_email')) {
            return redirect()->to('/customer/track-order');
        }
        
        $items = $db->table('order_items')
                    ->select('order_items.*, products.name as product_name')
                    ->join('products', 'products.id = order_items.product_id')
                    ->where('order_items.order_id', $order['id'])
                    ->get()
                    ->getResultArray();
        
        $order['items'] = $items;
        
        if(isset($order['rider_id']) && $order['rider_id']) {
            $rider = $db->table('riders')
                        ->select('name, phone, vehicle_type, plate_number')
                        ->where('id', $order['rider_id'])
                        ->get()
                        ->getRowArray();
            if($rider) {
                $order['rider_name'] = $rider['name'];
                $order['rider_phone'] = $rider['phone'];
                $order['rider_vehicle'] = $rider['vehicle_type'] ?? 'N/A';
                $order['rider_plate'] = $rider['plate_number'] ?? 'N/A';
            }
        }
        
        return view('customer/public_template', [
            'title' => 'Order Details',
            'content' => view('customer/order_detail', ['order' => $order])
        ]);
    }
    
    public function account()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('/customer/login');
        }
        
        return view('customer/public_template', [
            'title' => 'My Account',
            'content' => view('customer/my_account')
        ]);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/customer');
    }
}
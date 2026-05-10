<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\CategoryModel;

class Customer extends BaseController
{
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
        
        return view('customer/template', [
            'title' => 'Home',
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
        
        $categories = $categoryModel->findAll();
        
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        
        return view('customer/template', [
            'title' => 'All Products',
            'content' => view('customer/products', $data)
        ]);
    }
    
    public function productDetail($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        $product = $productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/customer/products')->with('error', 'Product not found');
        }
        
        if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
            $product['image_url'] = base_url('uploads/products/' . $product['image']);
        } else {
            $product['image_url'] = base_url('assets/images/default-product.png');
        }
        
        if($product['category_id']) {
            $category = $categoryModel->find($product['category_id']);
            $product['category_name'] = $category['name'] ?? 'Uncategorized';
        } else {
            $product['category_name'] = 'Uncategorized';
        }
        
        $related = [];
        if ($product['category_id']) {
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
        
        $data = [
            'product' => $product,
            'related' => $related
        ];
        
        return view('customer/template', [
            'title' => $product['name'],
            'content' => view('customer/product_detail', $data)
        ]);
    }
    
    public function placeOrder()
{
    $cart = json_decode($this->request->getPost('cart'), true);
    $customer_name = $this->request->getPost('customer_name');
    $customer_email = $this->request->getPost('customer_email');
    $customer_phone = $this->request->getPost('customer_phone');
    $delivery_address = $this->request->getPost('delivery_address');
    
    // Validate input
    if (empty($cart)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Cart is empty']);
    }
    
    if (empty($customer_name) || empty($customer_email) || empty($customer_phone) || empty($delivery_address)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Please fill in all fields']);
    }
    
    $productModel = new ProductModel();
    $orderModel = new OrderModel();
    $db = \Config\Database::connect();
    
    $total_amount = 0;
    
    // Calculate total and validate stock
    foreach($cart as $item) {
        $product = $productModel->find($item['id']);
        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found: ' . $item['name']]);
        }
        if ($product['stock'] < $item['quantity']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Insufficient stock for ' . $product['name']]);
        }
        $total_amount += $product['price'] * $item['quantity'];
    }
    
    // Generate order number
    $order_number = 'ORD-' . date('Ymd') . '-' . rand(100, 999);
    
    // Start transaction
    $db->transStart();
    
    // Insert order
    $orderData = [
        'order_number' => $order_number,
        'customer_name' => $customer_name,
        'order_type' => 'online',
        'total' => $total_amount,
        'status' => 'pending'
    ];
    
    $orderModel->insert($orderData);
    $order_id = $orderModel->getInsertID();
    
    // Insert order items and update stock
    foreach($cart as $item) {
        $product = $productModel->find($item['id']);
        
        $db->table('order_items')->insert([
            'order_id' => $order_id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'price' => $product['price']
        ]);
        
        // Update stock
        $new_stock = $product['stock'] - $item['quantity'];
        $productModel->update($item['id'], ['stock' => $new_stock]);
    }
    
    $db->transComplete();
    
    if ($db->transStatus() === false) {
        return $this->response->setJSON(['success' => false, 'message' => 'Transaction failed. Please try again.']);
    }
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Order placed successfully!',
        'order_number' => $order_number,
        'total' => $total_amount
    ]);
}
    
    public function category($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        $category = $categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/customer/products')->with('error', 'Category not found');
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
        
        return view('customer/template', [
            'title' => $category['name'],
            'content' => view('customer/category', $data)
        ]);
    }
    
    public function trackOrder()
    {
        $order_number = $this->request->getGet('order_number');
        
        if ($order_number) {
            $db = \Config\Database::connect();
            
            $order = $db->table('orders')
                        ->where('order_number', $order_number)
                        ->get()
                        ->getRowArray();
            
            if ($order) {
                if (!isset($order['status'])) {
                    $order['status'] = 'pending';
                }
                
                $items = $db->table('order_items')
                            ->select('order_items.*, products.name')
                            ->join('products', 'products.id = order_items.product_id')
                            ->where('order_items.order_id', $order['id'])
                            ->get()
                            ->getResultArray();
                
                $data = [
                    'order' => $order,
                    'items' => $items,
                    'found' => true
                ];
            } else {
                $data = ['found' => false, 'message' => 'Order not found. Please check your order number.'];
            }
        } else {
            $data = ['found' => false];
        }
        
        return view('customer/template', [
            'title' => 'Track Order',
            'content' => view('customer/track_order', $data)
        ]);
    }
    
    public function about()
    {
        return view('customer/template', [
            'title' => 'About Us',
            'content' => view('customer/about')
        ]);
    }
    
    public function contact()
    {
        return view('customer/template', [
            'title' => 'Contact Us',
            'content' => view('customer/contact')
        ]);
    }
}
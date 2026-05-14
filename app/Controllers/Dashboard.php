<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Staff cannot access dashboard, redirect to POS
        if (session()->get('role') === 'staff') {
            return redirect()->to('/pos');
        }
        
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $db = \Config\Database::connect();
        
        // Get all products
        $products = $productModel->findAll();
        
        // Calculate total stock and low stock count
        $total_stock = 0;
        $low_stock_count = 0;
        
        foreach($products as $product) {
            $total_stock += $product['stock'];
            if($product['stock'] < 20 && $product['stock'] > 0) {
                $low_stock_count++;
            }
        }
        
        // Get total orders count
        $total_orders = $db->table('orders')->countAllResults();
        
        // Get recent orders (limit to 5 for compact display)
        $recent_orders = $db->table('orders')
                            ->select('order_number, customer_name, total, order_date, status')
                            ->orderBy('order_date', 'DESC')
                            ->limit(5)
                            ->get()
                            ->getResultArray();
        
        $data = [
            'total_products'   => count($products),
            'total_stock'      => $total_stock,
            'low_stock_count'  => $low_stock_count,
            'total_orders'     => $total_orders,
            'recent_orders'    => $recent_orders
        ];
        
        return view('template', [
            'title'       => 'Dashboard',
            'active_menu' => 'dashboard',
            'content'     => view('dashboard', $data)
        ]);
    }
}
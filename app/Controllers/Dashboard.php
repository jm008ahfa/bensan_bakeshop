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
        
        $products = $productModel->findAll();
        
        $total_stock = 0;
        $low_stock_count = 0;
        
        foreach($products as $product) {
            $total_stock += $product['stock'];
            if($product['stock'] < 20) {
                $low_stock_count++;
            }
        }
        
        $total_orders = $orderModel->countAll();
        
        $recent_orders = $db->table('orders')
                            ->select('id, order_number, customer_name, total, order_date')
                            ->orderBy('order_date', 'DESC')
                            ->limit(5)
                            ->get()
                            ->getResultArray();
        
        $data = [
            'products'       => $products,
            'total_products' => count($products),
            'total_stock'    => $total_stock,
            'low_stock_count'=> $low_stock_count,
            'total_orders'   => $total_orders,
            'recent_orders'  => $recent_orders
        ];
        
        return view('template', [
            'title'       => 'Dashboard',
            'active_menu' => 'dashboard',
            'content'     => view('dashboard', $data)
        ]);
    }
}
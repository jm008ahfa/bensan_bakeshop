<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Reports extends BaseController
{
    public function __construct()
    {
        if (!session()->get('logged_in')) {
            redirect()->to('/login');
        }
    }
    
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get today's sales
        $today = date('Y-m-d');
        $todaySales = $db->table('orders')
                         ->selectSum('total')
                         ->where('DATE(order_date)', $today)
                         ->where('status', 'completed')
                         ->get()
                         ->getRowArray();
        
        // Get yesterday's sales
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $yesterdaySales = $db->table('orders')
                             ->selectSum('total')
                             ->where('DATE(order_date)', $yesterday)
                             ->where('status', 'completed')
                             ->get()
                             ->getRowArray();
        
        // Get this month's sales
        $thisMonth = date('Y-m');
        $monthSales = $db->table('orders')
                         ->selectSum('total')
                         ->where('DATE_FORMAT(order_date, "%Y-%m")', $thisMonth)
                         ->where('status', 'completed')
                         ->get()
                         ->getRowArray();
        
        // Get last month's sales
        $lastMonth = date('Y-m', strtotime('-1 month'));
        $lastMonthSales = $db->table('orders')
                             ->selectSum('total')
                             ->where('DATE_FORMAT(order_date, "%Y-%m")', $lastMonth)
                             ->where('status', 'completed')
                             ->get()
                             ->getRowArray();
        
        // Get total orders count
        $totalOrders = $db->table('orders')->countAllResults();
        
        // Get completed orders count
        $completedOrders = $db->table('orders')->where('status', 'completed')->countAllResults();
        
        // Get pending orders count
        $pendingOrders = $db->table('orders')->where('status', 'pending')->countAllResults();
        
        // Get total customers
        $totalCustomers = $db->table('customers')->countAllResults();
        
        // Get today's orders count
        $todayOrders = $db->table('orders')
                          ->where('DATE(order_date)', $today)
                          ->countAllResults();
        
        // Calculate growth percentages
        $todaySalesAmount = $todaySales['total'] ?? 0;
        $yesterdaySalesAmount = $yesterdaySales['total'] ?? 0;
        $monthSalesAmount = $monthSales['total'] ?? 0;
        $lastMonthSalesAmount = $lastMonthSales['lastMonth'] ?? 0;
        
        $dailyGrowth = $yesterdaySalesAmount > 0 ? (($todaySalesAmount - $yesterdaySalesAmount) / $yesterdaySalesAmount) * 100 : 0;
        $monthlyGrowth = $lastMonthSalesAmount > 0 ? (($monthSalesAmount - $lastMonthSalesAmount) / $lastMonthSalesAmount) * 100 : 0;
        
        $data = [
            'todaySales' => $todaySalesAmount,
            'yesterdaySales' => $yesterdaySalesAmount,
            'monthSales' => $monthSalesAmount,
            'lastMonthSales' => $lastMonthSalesAmount,
            'dailyGrowth' => round($dailyGrowth, 1),
            'monthlyGrowth' => round($monthlyGrowth, 1),
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'totalCustomers' => $totalCustomers,
            'todayOrders' => $todayOrders
        ];
        
        return view('template', [
            'title' => 'Reports & Analytics',
            'active_menu' => 'reports',
            'content' => view('reports/index', $data)
        ]);
    }
    
    public function salesReport()
    {
        $db = \Config\Database::connect();
        
        $filter = $this->request->getGet('filter') ?? 'daily';
        $date = $this->request->getGet('date') ?? date('Y-m-d');
        
        switch($filter) {
            case 'daily':
                $salesData = $db->table('orders')
                                ->select('DATE(order_date) as date, SUM(total) as total, COUNT(id) as count')
                                ->where('DATE(order_date)', $date)
                                ->where('status', 'completed')
                                ->groupBy('DATE(order_date)')
                                ->get()
                                ->getResultArray();
                break;
            case 'weekly':
                $salesData = $db->table('orders')
                                ->select('DATE(order_date) as date, SUM(total) as total, COUNT(id) as count')
                                ->where('YEARWEEK(order_date)', 'YEARWEEK(CURDATE())')
                                ->where('status', 'completed')
                                ->groupBy('DATE(order_date)')
                                ->orderBy('date', 'ASC')
                                ->get()
                                ->getResultArray();
                break;
            case 'monthly':
                $month = $this->request->getGet('month') ?? date('Y-m');
                $salesData = $db->table('orders')
                                ->select('DATE(order_date) as date, SUM(total) as total, COUNT(id) as count')
                                ->where('DATE_FORMAT(order_date, "%Y-%m")', $month)
                                ->where('status', 'completed')
                                ->groupBy('DATE(order_date)')
                                ->orderBy('date', 'ASC')
                                ->get()
                                ->getResultArray();
                break;
            case 'yearly':
                $year = $this->request->getGet('year') ?? date('Y');
                $salesData = $db->table('orders')
                                ->select('MONTH(order_date) as month, SUM(total) as total, COUNT(id) as count')
                                ->where('YEAR(order_date)', $year)
                                ->where('status', 'completed')
                                ->groupBy('MONTH(order_date)')
                                ->orderBy('month', 'ASC')
                                ->get()
                                ->getResultArray();
                break;
            default:
                $salesData = [];
        }
        
        $data = [
            'salesData' => $salesData,
            'filter' => $filter,
            'date' => $date
        ];
        
        return view('template', [
            'title' => 'Sales Report',
            'active_menu' => 'reports',
            'content' => view('reports/sales', $data)
        ]);
    }
    
    public function productReport()
    {
        $db = \Config\Database::connect();
        
        // Top selling products
        $topProducts = $db->table('order_items')
                          ->select('products.name, products.price, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as total_revenue')
                          ->join('products', 'products.id = order_items.product_id')
                          ->join('orders', 'orders.id = order_items.order_id')
                          ->where('orders.status', 'completed')
                          ->groupBy('order_items.product_id')
                          ->orderBy('total_sold', 'DESC')
                          ->limit(10)
                          ->get()
                          ->getResultArray();
        
        // Low stock products
        $lowStock = $db->table('products')
                       ->select('id, name, stock, price')
                       ->where('stock <', 20)
                       ->orderBy('stock', 'ASC')
                       ->get()
                       ->getResultArray();
        
        // Out of stock products
        $outOfStock = $db->table('products')
                         ->select('id, name, stock, price')
                         ->where('stock', 0)
                         ->get()
                         ->getResultArray();
        
        $data = [
            'topProducts' => $topProducts,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock
        ];
        
        return view('template', [
            'title' => 'Product Report',
            'active_menu' => 'reports',
            'content' => view('reports/products', $data)
        ]);
    }
    
    public function customerReport()
    {
        $db = \Config\Database::connect();
        
        // Top customers by spending
        $topCustomers = $db->table('orders')
                           ->select('customer_name, customer_email, customer_phone, SUM(total) as total_spent, COUNT(id) as order_count')
                           ->where('status', 'completed')
                           ->groupBy('customer_email')
                           ->orderBy('total_spent', 'DESC')
                           ->limit(10)
                           ->get()
                           ->getResultArray();
        
        // New customers this month
        $newCustomers = $db->table('customers')
                           ->select('name, email, phone, created_at')
                           ->where('MONTH(created_at)', date('m'))
                           ->orderBy('created_at', 'DESC')
                           ->limit(10)
                           ->get()
                           ->getResultArray();
        
        $data = [
            'topCustomers' => $topCustomers,
            'newCustomers' => $newCustomers
        ];
        
        return view('template', [
            'title' => 'Customer Report',
            'active_menu' => 'reports',
            'content' => view('reports/customers', $data)
        ]);
    }
    
    public function riderReport()
    {
        $db = \Config\Database::connect();
        
        // Rider performance
        $riderPerformance = $db->table('orders')
                               ->select('rider_name, COUNT(id) as deliveries, SUM(total) as total_amount, AVG(TIMESTAMPDIFF(MINUTE, confirmed_by_rider_at, delivered_at)) as avg_delivery_time')
                               ->where('rider_id IS NOT NULL')
                               ->where('delivery_status', 'delivered')
                               ->groupBy('rider_id')
                               ->orderBy('deliveries', 'DESC')
                               ->get()
                               ->getResultArray();
        
        $data = [
            'riderPerformance' => $riderPerformance
        ];
        
        return view('template', [
            'title' => 'Rider Report',
            'active_menu' => 'reports',
            'content' => view('reports/riders', $data)
        ]);
    }
}
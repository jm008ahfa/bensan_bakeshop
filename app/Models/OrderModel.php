<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_number', 'customer_name', 'customer_email', 'customer_phone', 
        'delivery_address', 'order_type', 'total', 'status', 'payment_method', 
        'payment_status', 'order_date', 'rider_id', 'rider_name', 
        'delivery_status', 'confirmed_by_rider_at', 'delivered_at', 
        'estimated_delivery_time'
    ];
    
    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . rand(100, 999);
    }
    
    public function getOrdersByCustomer($email)
    {
        return $this->where('customer_email', $email)
                    ->orderBy('order_date', 'DESC')
                    ->findAll();
    }
    
    public function getOrderWithItems($order_number)
    {
        $db = \Config\Database::connect();
        
        $order = $this->where('order_number', $order_number)->first();
        
        if ($order) {
            $items = $db->table('order_items')
                        ->select('order_items.*, products.name as product_name, products.price as product_price')
                        ->join('products', 'products.id = order_items.product_id')
                        ->where('order_items.order_id', $order['id'])
                        ->get()
                        ->getResultArray();
            $order['items'] = $items;
        }
        
        return $order;
    }
    
    public function updateStatus($order_id, $status)
    {
        if (empty($status)) {
            return false;
        }
        return $this->update($order_id, ['status' => $status]);
    }
    
    public function updateDeliveryStatus($order_id, $delivery_status)
    {
        if (empty($delivery_status)) {
            return false;
        }
        return $this->update($order_id, ['delivery_status' => $delivery_status]);
    }
}
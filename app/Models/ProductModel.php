<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock', 'image', 'category_id'];
    
    public function getProductsWithCategory()
    {
        $db = \Config\Database::connect();
        return $db->table('products')
                  ->select('products.*, categories.name as category_name, categories.id as category_id')
                  ->join('categories', 'categories.id = products.category_id', 'left')
                  ->orderBy('products.name', 'ASC')
                  ->get()
                  ->getResultArray();
    }
    
    public function getProductsByCategory($category_id)
    {
        $db = \Config\Database::connect();
        return $db->table('products')
                  ->select('products.*, categories.name as category_name')
                  ->join('categories', 'categories.id = products.category_id', 'left')
                  ->where('products.category_id', $category_id)
                  ->get()
                  ->getResultArray();
    }
    
    public function getProductsWithImage()
    {
        $products = $this->getProductsWithCategory();
        foreach($products as &$product) {
            if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                $product['image_url'] = base_url('uploads/products/' . $product['image']);
            } else {
                $product['image_url'] = base_url('assets/images/default-product.png');
            }
        }
        return $products;
    }
}
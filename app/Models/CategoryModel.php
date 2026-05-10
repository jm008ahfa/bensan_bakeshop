<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = false;
    
    public function getCategoriesWithProductCount()
    {
        $db = \Config\Database::connect();
        return $db->table('categories')
                  ->select('categories.*, COUNT(products.id) as product_count')
                  ->join('products', 'products.category_id = categories.id', 'left')
                  ->groupBy('categories.id')
                  ->orderBy('categories.name', 'ASC')
                  ->get()
                  ->getResultArray();
    }
    
    public function getCategoryByName($name)
    {
        return $this->where('LOWER(name)', strtolower($name))->first();
    }
}
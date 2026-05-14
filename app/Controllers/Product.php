<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Product extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $products = $model->findAll();
        
        foreach($products as &$product) {
            if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
                $product['image_url'] = base_url('uploads/products/' . $product['image']);
            } else {
                $product['image_url'] = base_url('assets/images/default-product.png');
            }
        }
        
        $data = ['products' => $products];
        
        return view('template', [
            'title' => 'Products',
            'active_menu' => 'products',
            'content' => view('product/index', $data)
        ]);
    }
    
    // THIS CREATE METHOD MUST EXIST
    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        
        return view('template', [
            'title' => 'Add Product',
            'active_menu' => 'products',
            'content' => view('product/create', $data)
        ]);
    }
    
    public function store()
    {
        $model = new ProductModel();
        
        $imageName = null;
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = 'uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $imageName = $file->getRandomName();
            $file->move($uploadPath, $imageName);
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'image' => $imageName,
            'category_id' => $this->request->getPost('category_id') ?: null
        ];
        
        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Product added successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to add product!');
        }
        
        return redirect()->to('/products');
    }
    
    public function edit($id)
    {
        $model = new ProductModel();
        $categoryModel = new CategoryModel();
        
        $product = $model->find($id);
        
        if (!$product) {
            session()->setFlashdata('error', 'Product not found!');
            return redirect()->to('/products');
        }
        
        if(!empty($product['image']) && file_exists('uploads/products/' . $product['image'])) {
            $product['image_url'] = base_url('uploads/products/' . $product['image']);
        } else {
            $product['image_url'] = base_url('assets/images/default-product.png');
        }
        
        $data = [
            'product' => $product,
            'categories' => $categoryModel->findAll()
        ];
        
        return view('template', [
            'title' => 'Edit Product',
            'active_menu' => 'products',
            'content' => view('product/edit', $data)
        ]);
    }
    
    public function update($id)
    {
        $model = new ProductModel();
        $existing = $model->find($id);
        
        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id') ?: null
        ];
        
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($existing['image'] && file_exists('uploads/products/' . $existing['image'])) {
                unlink('uploads/products/' . $existing['image']);
            }
            
            $uploadPath = 'uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $imageName = $file->getRandomName();
            $file->move($uploadPath, $imageName);
            $data['image'] = $imageName;
        }
        
        if ($model->update($id, $data)) {
            session()->setFlashdata('success', 'Product updated successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to update product!');
        }
        
        return redirect()->to('/products');
    }
    
    public function delete($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
        
        if ($product['image'] && file_exists('uploads/products/' . $product['image'])) {
            unlink('uploads/products/' . $product['image']);
        }
        
        $db = \Config\Database::connect();
        $hasOrders = $db->table('order_items')->where('product_id', $id)->countAllResults();
        
        if ($hasOrders > 0) {
            session()->setFlashdata('error', 'Cannot delete product with existing orders!');
            return redirect()->to('/products');
        }
        
        if ($model->delete($id)) {
            session()->setFlashdata('success', 'Product deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to delete product!');
        }
        
        return redirect()->to('/products');
    }
}
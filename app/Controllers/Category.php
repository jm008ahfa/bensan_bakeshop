<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        
        // Get all categories
        $categories = $model->findAll();
        
        // Get product count for each category
        $db = \Config\Database::connect();
        foreach($categories as &$cat) {
            $count = $db->table('products')
                        ->where('category_id', $cat['id'])
                        ->countAllResults();
            $cat['product_count'] = $count;
        }
        
        $data = ['categories' => $categories];
        
        return view('template', [
            'title' => 'Categories',
            'active_menu' => 'categories',
            'content' => view('category/index', $data)
        ]);
    }
    
    public function create()
    {
        return view('template', [
            'title' => 'Add Category',
            'active_menu' => 'categories',
            'content' => view('category/create')
        ]);
    }
    
    public function store()
    {
        $model = new CategoryModel();
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Category added successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to add category!');
        }
        
        return redirect()->to('/categories');
    }
    
    public function edit($id)
    {
        $model = new CategoryModel();
        $data['category'] = $model->find($id);
        
        if (!$data['category']) {
            session()->setFlashdata('error', 'Category not found!');
            return redirect()->to('/categories');
        }
        
        return view('template', [
            'title' => 'Edit Category',
            'active_menu' => 'categories',
            'content' => view('category/edit', $data)
        ]);
    }
    
    public function update($id)
    {
        $model = new CategoryModel();
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($model->update($id, $data)) {
            session()->setFlashdata('success', 'Category updated successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to update category!');
        }
        
        return redirect()->to('/categories');
    }
    
    public function delete($id)
    {
        $model = new CategoryModel();
        $db = \Config\Database::connect();
        
        // Check if category has products
        $hasProducts = $db->table('products')->where('category_id', $id)->countAllResults();
        
        if ($hasProducts > 0) {
            session()->setFlashdata('error', 'Cannot delete category with existing products!');
            return redirect()->to('/categories');
        }
        
        if ($model->delete($id)) {
            session()->setFlashdata('success', 'Category deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to delete category!');
        }
        
        return redirect()->to('/categories');
    }
}
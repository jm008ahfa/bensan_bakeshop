<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'fullname', 'role'];
    
    public function login($username, $password)
    {
        return $this->where('username', $username)
                    ->where('password', md5($password))
                    ->first();
    }
    
    public function getAllUsers()
    {
        return $this->findAll();
    }
    
    public function createAdmin($data)
    {
        $data['password'] = md5($data['password']);
        $data['role'] = 'admin';
        return $this->insert($data);
    }
    
    public function createStaff($data)
    {
        $data['password'] = md5($data['password']);
        $data['role'] = 'staff';
        return $this->insert($data);
    }
}
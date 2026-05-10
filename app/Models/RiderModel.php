<?php

namespace App\Models;

use CodeIgniter\Model;

class RiderModel extends Model
{
    protected $table = 'riders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'password', 'vehicle_type', 'plate_number', 'status'];
}
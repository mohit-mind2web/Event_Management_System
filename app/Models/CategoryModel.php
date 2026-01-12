<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'image', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}

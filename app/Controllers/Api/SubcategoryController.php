<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\SubcategoryModel;

class SubcategoryController extends ResourceController
{
    public function getByCategory($categoryId = null)
    {
        if (!$categoryId) {
             return $this->failNotFound('Category ID is required');
        }

        $subcategoryModel = new SubcategoryModel();
        $subcategories = $subcategoryModel->where('category_id', $categoryId)
                                          ->where('status', '1') 
                                          ->findAll();

        return $this->respond($subcategories);
    }
}

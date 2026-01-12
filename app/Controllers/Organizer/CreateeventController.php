<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CreateeventController extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->where('status', '1')->findAll();

        return view('organizer/createevent', ['categories' => $categories]);
    }
}

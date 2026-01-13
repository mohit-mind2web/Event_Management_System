<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;

class ManageCategoriesController extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();

        // Fetch all categories
        $categories = $categoryModel->orderBy('name', 'ASC')->findAll();
        foreach ($categories as &$category) {
            $category['subcategories'] = $subcategoryModel->where('category_id', $category['id'])->findAll();
        }

        return view('admin/manage_categories', ['categories' => $categories]);
    }

    public function storeCategory()
    {
        $categoryModel = new CategoryModel();
        
        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        if ($categoryModel->where('name', $name)->first()) {
             return redirect()->back()->with('error', 'Category already exists.');
        }

        $data = [
            'name' => $name,
            'slug' => $slug,
            'status' => 1 
        ];

        $categoryModel->save($data);
        return redirect()->to('/admin/manage-categories')->with('message', 'Category added successfully.');
    }

    public function storeSubcategory()
    {
        $subcategoryModel = new SubcategoryModel();
        
        $categoryId = $this->request->getPost('category_id');
        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        if ($subcategoryModel->where('name', $name)->where('category_id', $categoryId)->first()) {
             return redirect()->back()->with('error', 'Subcategory already exists for this category.');
        }

        $data = [
            'category_id' => $categoryId,
            'name' => $name,
            'slug' => $slug,
            'status' => 1
        ];

        $subcategoryModel->save($data);
        return redirect()->to('/admin/manage-categories')->with('message', 'Subcategory added successfully.');
    }

    public function deleteCategory($id)
    {
        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();
        $subcategoryModel->where('category_id', $id)->delete();
        $categoryModel->delete($id);

        return redirect()->to('/admin/manage-categories')->with('message', 'Category deleted successfully.');
    }

    public function deleteSubcategory($id)
    {
        $subcategoryModel = new SubcategoryModel();
        $subcategoryModel->delete($id);

        return redirect()->to('/admin/manage-categories')->with('message', 'Subcategory deleted successfully.');
    }
}

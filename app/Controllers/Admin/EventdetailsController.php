<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;

class EventdetailsController extends BaseController
{
    public function view($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);

        if (!$event) {
            return redirect()->to('/admin/event-approval')->with('error', 'Event not found');
        }

        // Fetch category and subcategory names
        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();
        
        $event['category_name'] = $categoryModel->find($event['category_id'])['name'] ?? 'N/A';
        $event['subcategory_name'] = $event['subcategory_id'] ? ($subcategoryModel->find($event['subcategory_id'])['name'] ?? 'N/A') : 'N/A';
        
        $readonly = $this->request->getGet('readonly') ? true : false;
        
        return view('admin/eventdetailspage', ['event' => $event, 'readonly' => $readonly]);
    }

    public function approve($id)
    {
        $eventModel = new EventModel();
        if (!$eventModel->find($id)) {
             return redirect()->to('/admin/event-approval')->with('error', 'Event not found.');
        }

        $eventModel->update($id, ['status' => 1]); 
        
        return redirect()->to('/admin/event-approval')->with('message', 'Event approved successfully.');
    }

    public function reject($id)
    {
        $eventModel = new EventModel();
         if (!$eventModel->find($id)) {
             return redirect()->to('/admin/event-approval')->with('error', 'Event not found.');
        }
        $eventModel->update($id, ['status' => 2]); 
        return redirect()->to('/admin/event-approval')->with('message', 'Event rejected successfully.');
    }
}

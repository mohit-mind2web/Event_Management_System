<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;

class EventDetailsController extends BaseController
{
    public function view($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);

        if (!$event) {
            return redirect()->to('/organizer/myevents')->with('error', 'Event not found');
        }
        
        // Ensure user owns the event
        if ($event['organizer_id'] != auth()->user()->id) {
             return redirect()->to('/organizer/myevents')->with('error', 'Unauthorized access');
        }

        // Fetch category and subcategory names for display
        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();
        
        $event['category_name'] = $categoryModel->find($event['category_id'])['name'] ?? 'N/A';
        $event['subcategory_name'] = $event['subcategory_id'] ? ($subcategoryModel->find($event['subcategory_id'])['name'] ?? 'N/A') : 'N/A';

        return view('organizer/event_details', ['event' => $event]);
    }

    public function edit($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);

        if (!$event) {
            return redirect()->to('/organizer/myevents')->with('error', 'Event not found');
        }
        
         if ($event['organizer_id'] != auth()->user()->id) {
             return redirect()->to('/organizer/myevents')->with('error', 'Unauthorized access');
        }
        
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->where('status', 1)->findAll();

        return view('organizer/edit_event', [
            'event' => $event,
            'categories' => $categories
        ]);
    }
}

<?php 
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
 class EventdetailController extends BaseController
 {
     public function view($id)
     {
         $eventModel = new EventModel();
         $event = $eventModel->find($id);
 
         if (!$event) {
             return redirect()->to('/user/events')->with('error', 'Event not found');
         }

        $userRegistrations = [];
        if (auth()->loggedIn()) {
            $registrationModel = new EventRegistrationModel();
            $registrations = $registrationModel->where('user_id', auth()->user()->id)
                                               ->findAll();
            
            foreach ($registrations as $reg) {
                $userRegistrations[$reg['event_id']] = $reg;
            }
        }
 
         // Fetch category and subcategory names
         $categoryModel = new CategoryModel();
         $subcategoryModel = new SubcategoryModel();
         
         $event['category_name'] = $categoryModel->find($event['category_id'])['name'] ?? 'N/A';
         $event['subcategory_name'] = $event['subcategory_id'] ? ($subcategoryModel->find($event['subcategory_id'])['name'] ?? 'N/A') : 'N/A';
         
         return view('user/eventdetails', [
            'event' => $event,
             'userRegistrations' => $userRegistrations,

        ]);
     }
 }
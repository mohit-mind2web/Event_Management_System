<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Controllers\User\EventRegistrationController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;

class EventRegistration extends BaseController{
    public function index(){
        $eventModel=new EventModel();
        $registrations=$eventModel->select('events.*,Count(event_registrations.id) as total_registrations,users.full_name as organizer_name,
        SUM(CASE WHEN event_registrations.status="confirmed" then 1 else 0 END) as confirmed_registrations,
        SUM(CASE WHEN event_registrations.status="pending" AND event_registrations.payment_status="unpaid" then 1 else 0 END) as pending_registrations')
                        ->join('event_registrations', 'events.id = event_registrations.event_id', 'left')
                        ->join('users','events.organizer_id=users.id','left')
                        ->groupBy('events.id')
                        ->orderBy('events.created_at','DESC')
                        ->findAll();
                        return view('admin/eventregistration', [
                      'registrations' => $registrations
        ]);
    }
     public function eventregistrationdetails($id){
        $eventuserModel=new EventRegistrationModel();
        $eventModel = new EventModel();
        
        $event = $eventModel->find($id);

        $registrationusers=$eventuserModel->select('event_registrations.*,users.full_name,auth_identities.secret as email')
                    ->join('users','event_registrations.user_id=users.id','left')
                    ->join('auth_identities','users.id=auth_identities.user_id','left')
                    ->where('event_registrations.event_id',$id)
                    ->findAll();

        return view('admin/registrationdetailpage',[
            'userregistrations'=>$registrationusers,
            'title' => $event['title'] ?? '',
            'start_datetime' => $event['start_datetime'] ?? ''
        ]);
    }
}
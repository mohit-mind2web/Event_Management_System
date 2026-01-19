<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Controllers\User\EventRegistrationController;
use App\Models\EventModel;
use App\Libraries\CsvExporter;
use App\Models\EventRegistrationModel;

class EventRegistration extends BaseController{
    // ... index method ...

    // ... eventregistrationdetails method ...

    public function export($id) {
        $eventuserModel=new EventRegistrationModel();
        $eventModel = new EventModel();
        $event = $eventModel->find($id);
        
        if (!$event) {
            return redirect()->back();
        }
        
        $search = $this->request->getGet('search');
        
        $query = $eventuserModel->select('event_registrations.*,users.full_name,auth_identities.secret as email')
                    ->join('users','event_registrations.user_id=users.id','left')
                    ->join('auth_identities','users.id=auth_identities.user_id','left')
                    ->where('event_registrations.event_id',$id);
                    
        if ($search) {
             $query->groupStart()
                   ->like('users.full_name', $search)
                   ->orLike('auth_identities.secret', $search)
                   ->groupEnd();
        }
        
        $registrations = $query->findAll();
        
        $filename = 'admin_registrations_' . preg_replace('/[^a-z0-9]+/', '_', strtolower($event['title'])) . '_' . date('Ymd') . '.csv';
        
        $exporter = new CsvExporter();
        $headers = ['Registration ID','Full Name', 'Email', 'Status', 'Payment Status', 'Registration Date', 'Checked In'];
        
        $exporter->export($filename, $headers, $registrations, function($reg) {
            return [
                $reg['id'],
                $reg['full_name'],
                $reg['email'],
                $reg['status'],
                $reg['payment_status'],
                $reg['created_at'],
                $reg['check_in'] ? 'Yes (' . $reg['checked_in_at'] . ')' : 'No'
            ];
        });
    }

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

        $search = $this->request->getGet('search');

        $query = $eventuserModel->select('event_registrations.*,users.full_name,auth_identities.secret as email')
                    ->join('users','event_registrations.user_id=users.id','left')
                    ->join('auth_identities','users.id=auth_identities.user_id','left')
                    ->where('event_registrations.event_id',$id);
        
        if ($search) {
             $query->groupStart()
                   ->like('users.full_name', $search)
                   ->orLike('auth_identities.secret', $search)
                   ->groupEnd();
        }

        $registrationusers = $query->paginate(20);

        return view('admin/registrationdetailpage',[
            'userregistrations' => $registrationusers,
            'pager' => $eventuserModel->pager,
            'title' => $event['title'] ?? '',
            'start_datetime' => $event['start_datetime'] ?? '',
            'end_datetime' => $event['end_datetime'] ?? '',
            'search' => $search
        ]);
    }
}
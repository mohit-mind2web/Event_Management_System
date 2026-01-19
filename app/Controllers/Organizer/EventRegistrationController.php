<?php 
namespace App\Controllers\Organizer;
use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;

class EventRegistrationController extends BaseController{
    public function index(){
        $eventModel=new EventModel();
        $userId = auth()->user()->id;
        
        $search = $this->request->getGet('search');
        $dateRange = $this->request->getGet('date_range');
        
        $startDate = null;
        $endDate = null;

        if ($dateRange) {
            $dates = explode(' to ', $dateRange);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1] . ' 23:59:59';
            } elseif (count($dates) == 1) {
                 $startDate = $dates[0];
                 $endDate = $dates[0] . ' 23:59:59';
            }
        }

        $query = $eventModel->select('events.*,Count(event_registrations.id) as total_registrations,
        SUM(CASE WHEN event_registrations.status="confirmed" then 1 else 0 END) as confirmed_registrations,
        SUM(CASE WHEN event_registrations.status="pending" AND event_registrations.payment_status="unpaid" then 1 else 0 END) as pending_registrations')
                        ->join('event_registrations', 'events.id = event_registrations.event_id', 'left')
                        ->where('events.organizer_id', $userId);
        
        if ($search) {
             $query->like('events.title', $search);
        }
        
        if ($startDate) {
             $query->where('events.start_datetime >=', $startDate);
        }
        
        if ($endDate) {
             $query->where('events.end_datetime <=', $endDate);
        }

        $registrations = $query->groupBy('events.id')
                        ->orderBy('events.created_at','DESC')
                        ->paginate(5);
        
        $pager = $eventModel->pager;

        $data = [
              'registrations' => $registrations,
              'pager' => $pager,
              'search' => $search,
              'date_range' => $dateRange
        ];
        
        if ($this->request->isAJAX()) {
             return view('organizer/partials/eventregistration_table', $data);
        }
                        
        return view('organizer/eventregistration', $data);
    }

    public function eventregistrationdetails($id){
        $eventuserModel=new EventRegistrationModel();
        $eventModel = new EventModel();
        
        $event = $eventModel->find($id);

        if (!$event) {
             return redirect()->to('/organizer/eventregistrations')->with('error', 'Event not found');
        }

        // Ensure user owns the event
        if ($event['organizer_id'] != auth()->user()->id) {
             return redirect()->to('/organizer/eventregistrations')->with('error', 'Unauthorized access');
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

        // Filter by Payment Status
        $paymentStatus = $this->request->getGet('payment_status');
        if ($paymentStatus) {
             $query->where('event_registrations.payment_status', $paymentStatus);
        }

        // Filter by Check-in Status
        $checkinStatus = $this->request->getGet('checkin_status');
        // Check explicitly for '0' or '1', assuming encoded as string in GET
        if ($checkinStatus !== null && $checkinStatus !== '') {
             $query->where('event_registrations.check_in', $checkinStatus);
        }

        $registrationusers = $query->paginate(20);
        $pager = $eventuserModel->pager;

        $data = [
            'userregistrations' => $registrationusers,
            'pager' => $pager,
            'title' => $event['title'] ?? '',
            'start_datetime' => $event['start_datetime'] ?? '',
            'end_datetime' => $event['end_datetime'] ?? '',
            'eventId' => $id,
            'search' => $search,
            'payment_status' => $paymentStatus,
            'checkin_status' => $checkinStatus
        ];
        
        if ($this->request->isAJAX()) {
             return view('organizer/partials/registration_details_table', $data);
        }

        return view('organizer/registrationdetailpage', $data);
    }
    
    public function exportEventRegistrations($id) {
        $eventuserModel=new EventRegistrationModel();
        $eventModel = new EventModel();
        $event = $eventModel->find($id);
        
        if (!$event || $event['organizer_id'] != auth()->user()->id) {
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

        // Filter by Payment Status
        $paymentStatus = $this->request->getGet('payment_status');
        if ($paymentStatus) {
             $query->where('event_registrations.payment_status', $paymentStatus);
        }

        // Filter by Check-in Status
        $checkinStatus = $this->request->getGet('checkin_status');
        if ($checkinStatus !== null && $checkinStatus !== '') {
             $query->where('event_registrations.check_in', $checkinStatus);
        }
        
        $registrations = $query->findAll();
        
        $filename = 'registrations_' . preg_replace('/[^a-z0-9]+/', '_', strtolower($event['title'])) . '_' . date('Ymd') . '.csv';
        
        $exporter = new \App\Libraries\CsvExporter();
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

    public function scan()
    {
        return view('organizer/scan_ticket');
    }

    public function processCheckIn()
    {
        $json = $this->request->getJSON();
        
        if (!$json || !isset($json->registration_id) || !isset($json->event_id)) {
             return $this->response->setJSON(['success' => false, 'message' => 'Invalid QR Code data.']);
        }

        $regId = $json->registration_id;
        $eventId = $json->event_id;

        $eventModel = new EventModel();
        $event = $eventModel->find($eventId);

        if (!$event) {
             return $this->response->setJSON(['success' => false, 'message' => 'Event not found.']);
        }

        // Verify Organizer owns the event
        if ($event['organizer_id'] != auth()->user()->id) {
             return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized: You are not the organizer of this event.']);
        }

        $registrationModel = new EventRegistrationModel();
        $registration = $registrationModel->find($regId);

        if (!$registration || $registration['event_id'] != $eventId) {
             return $this->response->setJSON(['success' => false, 'message' => 'Invalid registration for this event.']);
        }

        if ($registration['check_in'] == 1) {
             return $this->response->setJSON(['success' => false, 'message' => 'User already checked in at ' . $registration['checked_in_at']]);
        }

        // Feature: Date Validation
        $currentDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime($event['start_datetime']));
        $endDate = $event['end_datetime'] ? date('Y-m-d', strtotime($event['end_datetime'])) : $startDate;

        if ($currentDate < $startDate || $currentDate > $endDate) {
             return $this->response->setJSON(['success' => false, 'message' => 'Check-in is only allowed on the event date(s).']);
        }

        // Update Check In
        $registrationModel->update($regId, [
            'check_in' => 1,
            'checked_in_at' => date('Y-m-d H:i:s')
        ]);

        // Get User Name for display
        $userModel = model('App\Models\UserModel');
        $user = $userModel->find($registration['user_id']);

        return $this->response->setJSON([
            'success' => true, 
            'message' => 'Check-in Successful!',
            'user_name' => $user->full_name ?? 'Guest'
        ]);
    }
}

<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\EventModel;

class EventController extends ResourceController
{
    public function create()
    {
        $rules = [
            'title'          => 'required|min_length[3]|max_length[255]',
            'category_id'    => 'required|integer',
            'subcategory_id' => 'permit_empty|integer',
            'start_datetime' => 'required|valid_date',
            'end_datetime'   => 'required|valid_date',
            'location' => 'required|min_length[3]|max_length[255]',
            'capacity' => 'required|integer|greater_than[0]|less_than_equal_to[100000]',
            'description' => 'required|min_length[10]|max_length[2000]',
            'price' => 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[1000000]',
            'banner_image' => 'uploaded[banner_image]|max_size[banner_image,2048]|is_image[banner_image]|mime_in[banner_image,image/jpg,image/jpeg,image/png]',
        ];

        // Conditional Validation for Price
        if ($this->request->getPost('is_paid') == '1') {
            $rules['price'] = 'required|decimal|greater_than[0]';
        }

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $userId = auth()->user()->id;
        $startDatetime = $this->request->getPost('start_datetime');
        $endDatetime   = $this->request->getPost('end_datetime');

        // Custom Date Validation
        $currentDate = date('Y-m-d H:i:s');
        if ($startDatetime < $currentDate) {
             return $this->fail(['start_datetime' => 'Start date cannot be in the past.']);
        }

        if ($endDatetime < $startDatetime) {
             return $this->fail(['end_datetime' => 'End date must be after the start date.']);
        }
        
        $data = [
            'organizer_id'   => $userId,
            'category_id'    => $this->request->getPost('category_id'),
            'subcategory_id' => $this->request->getPost('subcategory_id') ?: null,
            'title'          => trim($this->request->getPost('title')),
            'description'    => trim($this->request->getPost('description')),
            'start_datetime' => $startDatetime,
            'end_datetime'   => $endDatetime,
            'location'       => trim($this->request->getPost('location')),
            'capacity'       => $this->request->getPost('capacity'),
            'is_paid'        => $this->request->getPost('is_paid') ? 1 : 0,
            'price'          => $this->request->getPost('price') ?: null,
            'status'         => 0 
        ];

        $file = $this->request->getFile('banner_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/events', $newName);
            $data['banner_image'] = 'uploads/events/' . $newName;
        }

        $eventModel = new EventModel();
        if ($eventModel->save($data)) {
            return $this->respondCreated(['message' => 'Event created successfully']);
        } else {
            return $this->failServerError('Failed to create event');
        }
    }

    public function update($id = null)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);

        if (!$event) {
            return $this->failNotFound('Event not found');
        }
        if ($event['organizer_id'] != auth()->user()->id) {
            return $this->failForbidden('Unauthorized access');
        }

        $rules = [
            'title'          => 'required|trim|strip_tags|min_length[3]|max_length[255]',
            'category_id'    => 'required|integer',
            'subcategory_id' => 'permit_empty|integer',
            'start_datetime' => 'required|valid_date',
            'end_datetime'   => 'required|valid_date',
            'location'       => 'required|min_length[3]|max_length[255]',
            'capacity'       => 'required|integer|greater_than[0]|less_than_equal_to[100000]',
            'description'    => 'required|min_length[10]|max_length[2000]',
            'price'          => 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[1000000]',
            'banner_image'   => 'permit_empty|uploaded[banner_image]|max_size[banner_image,2048]|is_image[banner_image]|mime_in[banner_image,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->request->getPost('is_paid') == '1') {
            $rules['price'] = 'required|decimal|greater_than[0]';
        }

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $startDatetime = $this->request->getPost('start_datetime');
        $endDatetime   = $this->request->getPost('end_datetime');
        
        $currentDate = date('Y-m-d H:i:s');
        if ($startDatetime < $currentDate) {
             return $this->fail(['start_datetime' => 'Start date cannot be in the past.']);
        }

        if ($endDatetime < $startDatetime) {
             return $this->fail(['end_datetime' => 'End date must be after the start date.']);
        }
        $data = [
            'category_id'    => $this->request->getPost('category_id'),
            'subcategory_id' => $this->request->getPost('subcategory_id') ?: null,
            'title'          => trim($this->request->getPost('title')),
            'description'    => trim($this->request->getPost('description')),
            'start_datetime' => $startDatetime,
            'end_datetime'   => $endDatetime,
            'location'       => trim($this->request->getPost('location')),
            'capacity'       => $this->request->getPost('capacity'),
            'is_paid'        => $this->request->getPost('is_paid') ? 1 : 0,
            'price'          => $this->request->getPost('price') ?: null,
        ];
        
        if ($event['status'] == 1) {
            $data['status'] = 0;
        }
        if ($event['status'] == 2) {
            $data['status'] = 0;
        }

        $file = $this->request->getFile('banner_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/events', $newName);
            $data['banner_image'] = 'uploads/events/' . $newName;
            
             if (!empty($event['banner_image']) && file_exists(FCPATH . $event['banner_image'])) {
                unlink(FCPATH . $event['banner_image']);
            }
        }

        if ($eventModel->update($id, $data)) {
            return $this->respond(['message' => 'Event updated successfully']);
        } else {
            return $this->failServerError('Failed to update event');
        }
    }
}

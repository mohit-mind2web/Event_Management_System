<?php

namespace App\Models;

use CodeIgniter\Model;

class EventRegistrationModel extends Model
{
    protected $table            = 'event_registrations';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['event_id', 'user_id', 'registration_date', 'status', 'payment_status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}

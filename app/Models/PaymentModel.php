<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'event_id', 'registration_id', 'amount', 'transaction_id', 'payment_date', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}

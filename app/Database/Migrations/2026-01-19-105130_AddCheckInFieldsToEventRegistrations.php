<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCheckInFieldsToEventRegistrations extends Migration
{
    public function up()
    {
        $this->forge->addColumn('event_registrations', [
            'check_in' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'payment_status'
            ],
            'checked_in_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'check_in'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('event_registrations', ['check_in', 'checked_in_at']);
    }
}

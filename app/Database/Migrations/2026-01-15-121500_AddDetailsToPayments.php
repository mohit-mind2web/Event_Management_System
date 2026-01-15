<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDetailsToPayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('payments', [
            'receipt_url' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status'
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'receipt_url'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('payments', ['receipt_url', 'payment_method']);
    }
}

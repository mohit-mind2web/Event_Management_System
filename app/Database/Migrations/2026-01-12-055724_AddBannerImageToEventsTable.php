<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBannerImageToEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('events', [
            'banner_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'price',
            ],
        ]);
    }

    public function down()
    {
         $this->forge->dropColumn('events', 'banner_image');
    }
}

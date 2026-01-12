<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
                'auto_increment'=>true,     
            ],
            'organizer_id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
            ],
            'category_id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
            ],
            'subcategory_id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
                'null'=>true,
            ],
            'title'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'description'=>[
                'type'=>'TEXT',
            ],
            'start_datetime'=>[
                'type'=>'DATETIME',
                'null'=>false,
            ],
            'end_datetime'=>[
                'type'=>'DATETIME',
                'null'=>false,
            ],
            'location'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>false,
            ],
            'capacity'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
            ],
            'is_paid'=>[
                'type'=>'TINYINT',
                'constraint'=>1,
                'default'=>0,
            ],
            'price'=>[
                'type'=>'DECIMAL',
                'constraint'=>'10,2',
                'null'=> true,
            ],
            'status'=>[
                'type'=>'TINYINT',
                'constraint'=>1,
                'default'=>0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('organizer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('subcategory_id', 'subcategories', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('events');
    }

    public function down()
    {
             $this->forge->dropTable('events');
    }
}

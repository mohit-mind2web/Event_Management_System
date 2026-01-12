<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubcategoriesTable extends Migration
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
            'category_id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
            ],
            'name'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'status'=>[
                'type'=>'TINYINT',
                'constraint'=>1,
                'default'=>1,
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ]
            ]);
            $this->forge->addKey('id',true);
            $this->forge->addForeignKey('category_id','categories','id','CASCADE','CASCADE');
            $this->forge->createTable('subcategories');
    }

    public function down()
    {
        $this->forge->dropTable('subcategories');
    }
}

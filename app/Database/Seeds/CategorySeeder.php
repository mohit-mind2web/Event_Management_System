<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        //categories data
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('categories')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
            $data = [
            ['name' => 'Corporate Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Social Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Wedding Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Cultural & Entertainment Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Educational Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Sports & Fitness Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Festivals & Fairs', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Religious & Spiritual Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Exhibitions & Trade Shows', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Online / Virtual Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'Charity & Community Events', 'status' => 1,'created_at'=>date('Y-m-d H:i:s')],
        ];
        $this->db->table('categories')->insertBatch($data);
    }
}

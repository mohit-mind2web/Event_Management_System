<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run()
    {
        //subcategoiries data
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('subcategories')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            // Corporate Events (category_id = 1)
            ['category_id' => 1, 'name' => 'Conferences', 'status' => 1],
            ['category_id' => 1, 'name' => 'Seminars', 'status' => 1],
            ['category_id' => 1, 'name' => 'Workshops', 'status' => 1],
            ['category_id' => 1, 'name' => 'Product Launches', 'status' => 1],
            ['category_id' => 1, 'name' => 'Board Meetings', 'status' => 1],
            // Social Events (category_id = 2)
            ['category_id' => 2, 'name' => 'Birthday Parties', 'status' => 1],
            ['category_id' => 2, 'name' => 'Anniversaries', 'status' => 1],
            ['category_id' => 2, 'name' => 'Baby Shower', 'status' => 1],
            ['category_id' => 2, 'name' => 'Reunion Parties', 'status' => 1],

            // Wedding Events (category_id = 3)
            ['category_id' => 3, 'name' => 'Engagement', 'status' => 1],
            ['category_id' => 3, 'name' => 'Mehendi', 'status' => 1],
            ['category_id' => 3, 'name' => 'Sangeet', 'status' => 1],
            ['category_id' => 3, 'name' => 'Wedding Ceremony', 'status' => 1],
            ['category_id' => 3, 'name' => 'Reception', 'status' => 1],

            // Educational Events (category_id = 5)
            ['category_id' => 5, 'name' => 'College Fests', 'status' => 1],
            ['category_id' => 5, 'name' => 'Training Programs', 'status' => 1],
            ['category_id' => 5, 'name' => 'Webinars', 'status' => 1],
            ['category_id' => 5, 'name' => 'Guest Lectures', 'status' => 1],

            // Online / Virtual Events (category_id = 9)
            ['category_id' => 9, 'name' => 'Online Workshops', 'status' => 1],
            ['category_id' => 9, 'name' => 'Virtual Conferences', 'status' => 1],

             // Cultural & Entertainment Events (category_id = 4)
             ['category_id' => 4, 'name' => 'Music Concerts', 'status' => 1],
             ['category_id' => 4, 'name' => 'Dance Shows', 'status' => 1],
             ['category_id' => 4, 'name' => 'Theatre / Drama', 'status' => 1],
             ['category_id' => 4, 'name' => 'Stand-up Comedy', 'status' => 1],
             ['category_id' => 4, 'name' => 'Fashion Shows', 'status' => 1],
             ['category_id' => 4, 'name' => 'Film Festivals', 'status' => 1],
        ];

        $this->db->table('subcategories')->insertBatch($data);
    }
}

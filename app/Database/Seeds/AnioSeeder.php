<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnioSeeder extends Seeder
{
    public function run()
    {
        for ($i = 2019; $i <= 2022; $i++) {

            $data = [
                'da_nombre' => (string) $i,
                'da_status' => 'A',
            ];

            // Using Query Builder
            $this->db->table('C_ANIOS')->insert($data);
        }

    }
}
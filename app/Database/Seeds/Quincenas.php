<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Quincenas extends Seeder
{
    public function run()
    {

        for ($i = 1; $i <= 24; $i++) {

            $data = [
                'da_nombre' => 'Quincena ' . (($i < 10) ? '0' . (string) $i : (string) $i),
                'da_status' => 'A',
            ];

            // Using Query Builder
            $this->db->table('C_QUINCENAS')->insert($data);
        }
    }
}
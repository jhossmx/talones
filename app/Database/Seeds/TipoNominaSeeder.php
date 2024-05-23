<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TipoNominaSeeder extends Seeder
{
    public function run()
    {

        $data = [
            'da_nombre' => 'ORDINARIA',
            'da_status' => 'A',
        ];

        // Using Query Builder
        $this->db->table('C_TIPONOMINA')->insert($data);

        $data = [
            'da_nombre' => 'EXTRAORDINARIA',
            'da_status' => 'A',
        ];

        // Using Query Builder
        $this->db->table('C_TIPONOMINA')->insert($data);

        $data = [
            'da_nombre' => 'NP',
            'da_status' => 'A',
        ];

        // Using Query Builder
        $this->db->table('C_TIPONOMINA')->insert($data);

    }
}
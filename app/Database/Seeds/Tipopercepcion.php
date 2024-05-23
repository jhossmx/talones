<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Tipopercepcion extends Seeder
{
    public function run()
    {
        $data = [
            'da_nombre' => 'PERCEPCION',
            'da_status' => 'A',
        ];

        // Using Query Builder
        $this->db->table('C_TIPO_PERCEPCION')->insert($data);

        $data = [
            'da_nombre' => 'DEDUCCION',
            'da_status' => 'A',
        ];

        // Using Query Builder
        $this->db->table('C_TIPO_PERCEPCION')->insert($data);

    }
}
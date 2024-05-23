<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Tipouser extends Seeder
{
    public function run()
    {
        $data = [
            'da_nombre' => 'ADMINISTRADOR',
            'da_status' => 'A',
        ];
        // Using Query Builder
        $this->db->table('C_TIPOUSUARIOS')->insert($data);

        $data = [
            'da_nombre' => 'USUARIO',
            'da_status' => 'A',
        ];
        // Using Query Builder
        $this->db->table('C_TIPOUSUARIOS')->insert($data);

    }
}
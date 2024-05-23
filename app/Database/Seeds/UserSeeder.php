<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        $data = [
            'da_email' => 'jhossmx@gmail.com',
            'da_clave' => password_hash('12345678', PASSWORD_DEFAULT),
            'da_nombre' => 'JOSE LUIS',
            'da_apell1' => 'RODRIGUEZ',
            'da_apell2' => 'VILLALOBOS',
            'fn_tipousuario' => 1,
            'da_status' => 'A',
        ];
        // Using Query Builder
        $this->db->table('S_USUARIOS')->insert($data);

        $data = [
            'da_email' => 'lizbethsin@gmail.com',
            'da_clave' => password_hash('12345678', PASSWORD_DEFAULT),
            'da_nombre' => 'LIZBETH KARINA',
            'da_apell1' => 'LUQUE',
            'da_apell2' => 'OCHOA',
            'fn_tipousuario' => 1,
            'da_status' => 'A',
        ];
        // Using Query Builder
        $this->db->table('S_USUARIOS')->insert($data);
    }
}
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    //https: //stackoverflow.com/questions/62353435/forge-migrate-codeigniter-4-foreign-key-error
    //https://www.desarrollolibre.net/blog/codeigniter/las-migraciones-en-codeigniter-4
    public function up()
    {
        $this->forge->addField([

            'cn_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'da_email' => [
                'type' => 'VARCHAR',
                'constraint' => '120',
                'unique'     => true
            ],

            'da_clave' => [
                'type' => 'VARCHAR',
                'constraint' => '120',
            ],

            'da_nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
            ],

            'da_apell1' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
            ],

            'da_apell2' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => true,
            ],

            'fn_tipousuario' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            'da_status' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'A',
            ],

        ]);

        $this->forge->addKey('cn_id', true);
        $this->forge->addForeignKey('fn_tipousuario', 'C_TIPOUSUARIOS', 'cn_id');
        $this->forge->createTable('S_USUARIOS');

    }

    public function down()
    {
        $this->forge->dropTable('S_USUARIOS');

    }
}
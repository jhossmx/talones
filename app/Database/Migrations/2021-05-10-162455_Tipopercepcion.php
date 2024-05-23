<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tipopercepcion extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'cn_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'da_nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
            ],

            'da_status' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'A',
            ],

        ]);

        $this->forge->addKey('cn_id', true);
        $this->forge->createTable('C_TIPO_PERCEPCION');

    }

    public function down()
    {
        $this->forge->dropTable('C_TIPO_PERCEPCION');

    }
}
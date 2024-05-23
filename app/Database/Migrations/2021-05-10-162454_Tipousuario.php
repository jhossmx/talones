<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tipousuario extends Migration
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
        $this->forge->createTable('C_TIPOUSUARIOS');

    }

    public function down()
    {
        $this->forge->dropTable('C_TIPOUSUARIOS');

    }
}
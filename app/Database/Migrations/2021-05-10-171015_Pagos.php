<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pagos extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'cn_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'fn_usuario' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],

            'fn_nomina' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            'fn_anio' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            'fn_quincena' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            'df_fecha_pago' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'df_fecha_inicio_pago' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'df_fecha_fin_pago' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'dn_dias_pago' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            'dn_subtotal' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],

            'dn_decucciones' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],

            'dn_total' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],

            'da_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
            ],

            'da_plaza' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],

            'da_status' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'A',
            ],

        ]);

        $this->forge->addKey('cn_id', true);
        $this->forge->addForeignKey('fn_usuario', 'S_USUARIOS', 'cn_id');
        $this->forge->addForeignKey('fn_nomina', 'C_TIPONOMINA', 'cn_id');
        $this->forge->addForeignKey('fn_anio', 'C_ANIOS', 'cn_id');
        $this->forge->addForeignKey('fn_quincena', 'C_QUINCENAS', 'cn_id');
        $this->forge->createTable('M_PAGOS');

    }

    public function down()
    {
        $this->forge->dropTable('M_PAGOS');

    }
}
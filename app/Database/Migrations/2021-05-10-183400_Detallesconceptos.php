<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Detallesconceptos extends Migration
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

            'fn_pago' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],

            'fn_usuario' => [
                'type' => 'INT',
                'constraint' => 5,
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

            //ingreso , deduccion
            'fn_tipoPercepcion' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            //ingreso , deduccion
            'fn_tipoConcepto' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

            'da_plaza' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            
            'da_clave' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],

            'da_descripcion' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],

            'dn_importe_gravado' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],

            'dn_importe_exento' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],

            'da_status' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'A',
            ],

        ]);

        $this->forge->addKey('cn_id', true);
        $this->forge->addForeignKey('fn_pago', 'M_PAGOS', 'cn_id');
        $this->forge->addForeignKey('fn_usuario', 'S_USUARIOS', 'cn_id');
        $this->forge->addForeignKey('fn_nomina', 'C_TIPONOMINA', 'cn_id');
        $this->forge->addForeignKey('fn_anio', 'C_ANIOS', 'cn_id');
        $this->forge->addForeignKey('fn_tipoPercepcion', 'C_TIPO_PERCEPCION', 'cn_id');
        $this->forge->addForeignKey('fn_quincena', 'C_QUINCENAS', 'cn_id');
        $this->forge->createTable('D_PAGOS');

    }

    public function down()
    {
        $this->forge->dropTable('D_PAGOS');
    }
}
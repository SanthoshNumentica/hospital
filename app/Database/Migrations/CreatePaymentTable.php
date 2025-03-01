<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'payments_id' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'payments_des' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'payment_date' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'credit_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'ref_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'payment_type_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'payment_ref_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'payment_remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 245,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payment');
    }

    public function down()
    {
        $this->forge->dropTable('payment');
    }
}

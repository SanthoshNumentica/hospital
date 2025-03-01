<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoiceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'patient_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'total_amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'total_paid_amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
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
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 300,
                'null' => true,
            ],
            'invoice_date' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'discount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'invoice_id' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('invoice');
    }

    public function down()
    {
        $this->forge->dropTable('invoice');
    }
}

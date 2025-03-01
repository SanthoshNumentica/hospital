<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExpenseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'expense_id' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'vendor_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
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
            'payment_type_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'payment_ref_number' => [
                'type' => 'VARCHAR',
                'constraint' => 300,
                'null' => true,
            ],
            'payment_ref_remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'total_paid' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'invoice_date' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'document' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'expense_type_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('expense');
    }

    public function down()
    {
        $this->forge->dropTable('expense');
    }
}

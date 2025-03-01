<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoice_itemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'invoice_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'treatment_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('invoice_item');
    }

    public function down()
    {
        $this->forge->dropTable('invoice_item');
    }
}

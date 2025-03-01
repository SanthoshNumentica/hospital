<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSmstransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'message_type' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'bulk_send' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
            ],
            'message' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('smstransactions');
    }

    public function down()
    {
        $this->forge->dropTable('smstransactions');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApp_logsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
            ],
            'message' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'module_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'action_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'ref_id' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('app_logs');
    }

    public function down()
    {
        $this->forge->dropTable('app_logs');
    }
}

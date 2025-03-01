<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBackground_taskTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'start_time' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => false,
            ],
            'end_time' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'pid' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'result_data' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'cmd_text' => [
                'type' => 'VARCHAR',
                'constraint' => 545,
                'null' => false,
            ],
            'uid' => [
                'type' => 'VARCHAR',
                'constraint' => 550,
                'null' => true,
            ],
            'schedule_time' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'ref_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'comment_text' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('background_task');
    }

    public function down()
    {
        $this->forge->dropTable('background_task');
    }
}

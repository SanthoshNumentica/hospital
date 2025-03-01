<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModule_actionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'module_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'action_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('module_action');
    }

    public function down()
    {
        $this->forge->dropTable('module_action');
    }
}

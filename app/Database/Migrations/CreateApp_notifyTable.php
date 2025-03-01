<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApp_notifyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'evnet_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'ref_id' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'ref_name' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'viewed_on' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('app_notify');
    }

    public function down()
    {
        $this->forge->dropTable('app_notify');
    }
}

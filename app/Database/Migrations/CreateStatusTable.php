<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatusTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'statusName' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('status');
    }

    public function down()
    {
        $this->forge->dropTable('status');
    }
}

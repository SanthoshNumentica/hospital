<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDb_query_logTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'db_query' => [
                'type' => 'VARCHAR',
                'constraint' => null,
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('db_query_log');
    }

    public function down()
    {
        $this->forge->dropTable('db_query_log');
    }
}

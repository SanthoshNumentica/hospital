<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUser_roleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'branch' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_role');
    }

    public function down()
    {
        $this->forge->dropTable('user_role');
    }
}

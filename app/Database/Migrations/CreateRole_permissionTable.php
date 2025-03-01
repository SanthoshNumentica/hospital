<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRole_permissionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'moduleActionId' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('role_permission');
    }

    public function down()
    {
        $this->forge->dropTable('role_permission');
    }
}

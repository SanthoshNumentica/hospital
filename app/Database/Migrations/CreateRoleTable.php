<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'roleName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'desgination' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('role');

        // Insert initial data
        $this->db->table('role')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'roleName' => 'Administrator',
    'status' => '1',
    'desgination' => NULL,
  ),
  1 => 
  array (
    'id' => '2',
    'roleName' => 'Doctor',
    'status' => '1',
    'desgination' => NULL,
  ),
  2 => 
  array (
    'id' => '3',
    'roleName' => 'Receptionist',
    'status' => '1',
    'desgination' => NULL,
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('role');
    }
}

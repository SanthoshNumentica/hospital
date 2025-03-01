<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStateTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'stateName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('state');

        // Insert initial data
        $this->db->table('state')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'stateName' => 'Tamilnadu',
    'status' => '1',
    'created_at' => '2023-11-27 16:23:15',
  ),
  1 => 
  array (
    'id' => '2',
    'stateName' => 'Kerala',
    'status' => '0',
    'created_at' => '2023-11-27 16:23:15',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('state');
    }
}

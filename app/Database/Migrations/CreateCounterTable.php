<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCounterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'counterName' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => false,
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
            'token_updated_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'last_token' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'token_prefix' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'initial_start_from' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'token_seperator' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('counter');

        // Insert initial data
        $this->db->table('counter')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'counterName' => 'First Floor',
    'status' => '1',
    'created_at' => '2024-01-31 10:08:45',
    'token_updated_at' => '2025-01-28 07:25:23',
    'last_token' => '1',
    'token_prefix' => 'F',
    'initial_start_from' => '1000',
    'token_seperator' => '',
  ),
  1 => 
  array (
    'id' => '2',
    'counterName' => 'Second Floor',
    'status' => '1',
    'created_at' => '2024-01-31 10:09:03',
    'token_updated_at' => '2025-01-29 06:51:14',
    'last_token' => '1',
    'token_prefix' => 'S',
    'initial_start_from' => '1000',
    'token_seperator' => '',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('counter');
    }
}

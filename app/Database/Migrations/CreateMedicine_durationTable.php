<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicine_durationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'medicine_durationName' => [
                'type' => 'VARCHAR',
                'constraint' => 75,
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('medicine_duration');

        // Insert initial data
        $this->db->table('medicine_duration')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'medicine_durationName' => '5 Days',
    'status' => '1',
    'created_at' => '2024-01-25 13:19:01',
  ),
  1 => 
  array (
    'id' => '3',
    'medicine_durationName' => '3 days ',
    'status' => '1',
    'created_at' => '2024-01-25 13:19:01',
  ),
  2 => 
  array (
    'id' => '4',
    'medicine_durationName' => '1 day',
    'status' => '1',
    'created_at' => '2024-01-25 13:19:01',
  ),
  3 => 
  array (
    'id' => '7',
    'medicine_durationName' => '7 days',
    'status' => '1',
    'created_at' => '2024-01-25 13:19:01',
  ),
  4 => 
  array (
    'id' => '9',
    'medicine_durationName' => 'daily',
    'status' => '1',
    'created_at' => '2024-01-25 13:19:01',
  ),
  5 => 
  array (
    'id' => '10',
    'medicine_durationName' => 'If needed',
    'status' => '1',
    'created_at' => '2024-01-25 13:19:01',
  ),
  6 => 
  array (
    'id' => '38',
    'medicine_durationName' => '30 days',
    'status' => '1',
    'created_at' => '2024-05-30 19:21:31',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('medicine_duration');
    }
}

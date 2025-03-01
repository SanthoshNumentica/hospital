<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicine_frequencyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'medicine_frequencyName' => [
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
        $this->forge->createTable('medicine_frequency');

        // Insert initial data
        $this->db->table('medicine_frequency')->insertBatch(array (
  0 => 
  array (
    'id' => '51',
    'medicine_frequencyName' => '1-0-1',
    'status' => '1',
    'created_at' => '2024-05-30 11:25:28',
  ),
  1 => 
  array (
    'id' => '52',
    'medicine_frequencyName' => '1-1-1',
    'status' => '1',
    'created_at' => '2024-05-30 11:25:33',
  ),
  2 => 
  array (
    'id' => '53',
    'medicine_frequencyName' => '0-1-1',
    'status' => '1',
    'created_at' => '2024-05-30 11:25:40',
  ),
  3 => 
  array (
    'id' => '54',
    'medicine_frequencyName' => 'daily 2 times',
    'status' => '1',
    'created_at' => '2024-05-30 11:28:23',
  ),
  4 => 
  array (
    'id' => '55',
    'medicine_frequencyName' => 'daily 3 times',
    'status' => '1',
    'created_at' => '2024-05-30 11:28:30',
  ),
  5 => 
  array (
    'id' => '56',
    'medicine_frequencyName' => '0-0-1',
    'status' => '1',
    'created_at' => '2024-05-30 19:22:31',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('medicine_frequency');
    }
}

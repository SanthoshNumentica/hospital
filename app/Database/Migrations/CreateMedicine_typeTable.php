<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicine_typeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'medicine_typeName' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
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
        $this->forge->createTable('medicine_type');

        // Insert initial data
        $this->db->table('medicine_type')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'medicine_typeName' => 'Tab',
    'status' => '1',
    'created_at' => '2023-11-28 16:21:44',
  ),
  1 => 
  array (
    'id' => '2',
    'medicine_typeName' => 'Syrub',
    'status' => '1',
    'created_at' => '2023-11-28 16:21:44',
  ),
  2 => 
  array (
    'id' => '3',
    'medicine_typeName' => 'Cab',
    'status' => '1',
    'created_at' => '2023-11-28 16:21:44',
  ),
  3 => 
  array (
    'id' => '5',
    'medicine_typeName' => 'Inj',
    'status' => '1',
    'created_at' => '2023-11-28 16:25:28',
  ),
  4 => 
  array (
    'id' => '6',
    'medicine_typeName' => 'tab',
    'status' => '0',
    'created_at' => '2024-01-08 11:30:26',
  ),
  5 => 
  array (
    'id' => '7',
    'medicine_typeName' => 'paste',
    'status' => '1',
    'created_at' => '2024-01-08 11:40:35',
  ),
  6 => 
  array (
    'id' => '8',
    'medicine_typeName' => 'mouth wash',
    'status' => '1',
    'created_at' => '2024-01-08 11:40:46',
  ),
  7 => 
  array (
    'id' => '9',
    'medicine_typeName' => 'gel',
    'status' => '1',
    'created_at' => '2024-01-08 11:41:04',
  ),
  8 => 
  array (
    'id' => '10',
    'medicine_typeName' => 'brush',
    'status' => '1',
    'created_at' => '2024-01-08 11:41:16',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('medicine_type');
    }
}

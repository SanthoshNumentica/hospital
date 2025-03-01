<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExaminationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'examinationName' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
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
            'color_code' => [
                'type' => 'VARCHAR',
                'constraint' => 75,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('examination');

        // Insert initial data
        $this->db->table('examination')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'examinationName' => 'Missing Tooth',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  1 => 
  array (
    'id' => '2',
    'examinationName' => 'Implant',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  2 => 
  array (
    'id' => '3',
    'examinationName' => 'Periparcial Abcess',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  3 => 
  array (
    'id' => '4',
    'examinationName' => 'tes_tooth',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  4 => 
  array (
    'id' => '5',
    'examinationName' => 'Mesial',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  5 => 
  array (
    'id' => '6',
    'examinationName' => 'Distal',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  6 => 
  array (
    'id' => '7',
    'examinationName' => 'Buccal',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  7 => 
  array (
    'id' => '8',
    'examinationName' => 'Ligual/Palatal',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  8 => 
  array (
    'id' => '9',
    'examinationName' => 'Occlusal',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  9 => 
  array (
    'id' => '10',
    'examinationName' => 'Root',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  10 => 
  array (
    'id' => '11',
    'examinationName' => 'Crown',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  11 => 
  array (
    'id' => '12',
    'examinationName' => 'Cervical',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  12 => 
  array (
    'id' => '13',
    'examinationName' => 'Insical',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  13 => 
  array (
    'id' => '14',
    'examinationName' => 'Bridge',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  14 => 
  array (
    'id' => '15',
    'examinationName' => 'Defective Crown',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  15 => 
  array (
    'id' => '16',
    'examinationName' => 'Amalgam Filling',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => '#1a00ff',
  ),
  16 => 
  array (
    'id' => '17',
    'examinationName' => 'Composite Filling',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  17 => 
  array (
    'id' => '18',
    'examinationName' => 'GIC Filling',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  18 => 
  array (
    'id' => '19',
    'examinationName' => 'Root Canal',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  19 => 
  array (
    'id' => '20',
    'examinationName' => 'Improper Extracted',
    'status' => '1',
    'created_at' => '2023-11-29 14:27:09',
    'color_code' => NULL,
  ),
  20 => 
  array (
    'id' => '21',
    'examinationName' => 'Post and Core',
    'status' => '1',
    'created_at' => '2023-11-29 14:29:20',
    'color_code' => NULL,
  ),
  21 => 
  array (
    'id' => '22',
    'examinationName' => 'Properly Extracted',
    'status' => '1',
    'created_at' => '2023-11-29 14:29:20',
    'color_code' => NULL,
  ),
  22 => 
  array (
    'id' => '23',
    'examinationName' => 'Root Piece',
    'status' => '1',
    'created_at' => '2023-11-29 14:29:20',
    'color_code' => NULL,
  ),
  23 => 
  array (
    'id' => '24',
    'examinationName' => 'RPD',
    'status' => '1',
    'created_at' => '2023-11-29 14:29:20',
    'color_code' => NULL,
  ),
  24 => 
  array (
    'id' => '25',
    'examinationName' => 'Cast Partial',
    'status' => '1',
    'created_at' => '2023-11-29 14:29:20',
    'color_code' => NULL,
  ),
  25 => 
  array (
    'id' => '26',
    'examinationName' => 'Complete Denture',
    'status' => '1',
    'created_at' => '2023-11-29 14:29:20',
    'color_code' => NULL,
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('examination');
    }
}

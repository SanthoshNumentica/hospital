<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlood_groupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'blood_groupName' => [
                'type' => 'VARCHAR',
                'constraint' => 55,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('blood_group');

        // Insert initial data
        $this->db->table('blood_group')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'blood_groupName' => 'A+',
    'status' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'blood_groupName' => 'A-',
    'status' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'blood_groupName' => 'B+',
    'status' => '1',
  ),
  3 => 
  array (
    'id' => '4',
    'blood_groupName' => 'B- ',
    'status' => '1',
  ),
  4 => 
  array (
    'id' => '5',
    'blood_groupName' => 'AB+',
    'status' => '1',
  ),
  5 => 
  array (
    'id' => '6',
    'blood_groupName' => 'O+',
    'status' => '1',
  ),
  6 => 
  array (
    'id' => '7',
    'blood_groupName' => 'O-',
    'status' => '1',
  ),
  7 => 
  array (
    'id' => '8',
    'blood_groupName' => 'AB-',
    'status' => '1',
  ),
  8 => 
  array (
    'id' => '9',
    'blood_groupName' => 'ABO',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('blood_group');
    }
}

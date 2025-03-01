<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGenderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'genderName' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('gender');

        // Insert initial data
        $this->db->table('gender')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'genderName' => 'Male',
    'status' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'genderName' => 'Female',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('gender');
    }
}

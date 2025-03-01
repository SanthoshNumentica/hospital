<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModuleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'moduleName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'moduleDes' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('module');

        // Insert initial data
        $this->db->table('module')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'moduleName' => 'PATIENT',
    'status' => '1',
    'moduleDes' => 'Patient',
  ),
  1 => 
  array (
    'id' => '2',
    'moduleName' => 'MASTER',
    'status' => '1',
    'moduleDes' => 'Settings',
  ),
  2 => 
  array (
    'id' => '3',
    'moduleName' => 'USER',
    'status' => '1',
    'moduleDes' => 'User',
  ),
  3 => 
  array (
    'id' => '4',
    'moduleName' => 'INVOICE',
    'status' => '1',
    'moduleDes' => 'Invoice',
  ),
  4 => 
  array (
    'id' => '5',
    'moduleName' => 'EXPENSE',
    'status' => '1',
    'moduleDes' => 'Expense',
  ),
  5 => 
  array (
    'id' => '6',
    'moduleName' => 'APPOINTMENT',
    'status' => '1',
    'moduleDes' => 'Appointment',
  ),
  6 => 
  array (
    'id' => '7',
    'moduleName' => 'PAYMENT',
    'status' => '1',
    'moduleDes' => 'Payment',
  ),
  7 => 
  array (
    'id' => '8',
    'moduleName' => 'REPORT',
    'status' => '1',
    'moduleDes' => 'Report',
  ),
  8 => 
  array (
    'id' => '9',
    'moduleName' => '',
    'status' => '1',
    'moduleDes' => NULL,
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('module');
    }
}

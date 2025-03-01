<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAction_nameTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'actionName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'actionDes' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('action_name');

        // Insert initial data
        $this->db->table('action_name')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'actionName' => 'ADD',
    'actionDes' => 'Add',
  ),
  1 => 
  array (
    'id' => '2',
    'actionName' => 'UPDATE',
    'actionDes' => 'Modify',
  ),
  2 => 
  array (
    'id' => '3',
    'actionName' => 'DELETE',
    'actionDes' => 'Delete',
  ),
  3 => 
  array (
    'id' => '4',
    'actionName' => 'READ',
    'actionDes' => 'Read',
  ),
  4 => 
  array (
    'id' => '5',
    'actionName' => 'MANAGE_MEDICINE',
    'actionDes' => 'Manage Medicine',
  ),
  5 => 
  array (
    'id' => '6',
    'actionName' => 'MANAGE_GENERAL',
    'actionDes' => 'Manage General',
  ),
  6 => 
  array (
    'id' => '7',
    'actionName' => 'MANAGE_LOCATION',
    'actionDes' => 'Manage Location',
  ),
  7 => 
  array (
    'id' => '8',
    'actionName' => 'VIEW_ALL',
    'actionDes' => 'View all',
  ),
  8 => 
  array (
    'id' => '9',
    'actionName' => 'VIEW_LOG',
    'actionDes' => 'view log',
  ),
  9 => 
  array (
    'id' => '10',
    'actionName' => 'MANAGE_ROLE',
    'actionDes' => 'manage role',
  ),
  10 => 
  array (
    'id' => '11',
    'actionName' => 'VIEW_PROFIT_LOSS',
    'actionDes' => 'Profit Loss Report',
  ),
  11 => 
  array (
    'id' => '12',
    'actionName' => 'VIEW_PATIENT_REPORT',
    'actionDes' => 'Patient Report',
  ),
  12 => 
  array (
    'id' => '13',
    'actionName' => 'VIEW_INVOICE_REPORT',
    'actionDes' => 'Invoice Report',
  ),
  13 => 
  array (
    'id' => '14',
    'actionName' => 'APPOINTMENT_REPORT',
    'actionDes' => 'Appointment Report',
  ),
  14 => 
  array (
    'id' => '15',
    'actionName' => 'BULK_MESSAGE',
    'actionDes' => 'Bulk Message',
  ),
  15 => 
  array (
    'id' => '16',
    'actionName' => 'MANAGE_SETTING',
    'actionDes' => 'Manage Setting',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('action_name');
    }
}

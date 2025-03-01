<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaster_config_idTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'master_config_idName' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'last_key' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'prefix' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'sep' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'is_year_append' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'is_month_append' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'padding' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'last_update_on' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_config_id');

        // Insert initial data
        $this->db->table('master_config_id')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'master_config_idName' => 'PATIENT',
    'last_key' => '2832',
    'prefix' => '',
    'sep' => '',
    'is_year_append' => '1',
    'is_month_append' => '1',
    'padding' => '4',
    'last_update_on' => '2025-01-28 16:01:25',
    'status' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'master_config_idName' => 'TOKEN',
    'last_key' => '3',
    'prefix' => '',
    'sep' => NULL,
    'is_year_append' => '0',
    'is_month_append' => '0',
    'padding' => '4',
    'last_update_on' => '2024-01-19 06:37:46',
    'status' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'master_config_idName' => 'INVOICE',
    'last_key' => '1000',
    'prefix' => 'INVO',
    'sep' => NULL,
    'is_year_append' => '0',
    'is_month_append' => '0',
    'padding' => '0',
    'last_update_on' => NULL,
    'status' => '0',
  ),
  3 => 
  array (
    'id' => '4',
    'master_config_idName' => 'EXPENSE',
    'last_key' => '100',
    'prefix' => 'EX',
    'sep' => NULL,
    'is_year_append' => '1',
    'is_month_append' => '1',
    'padding' => '4',
    'last_update_on' => '2024-01-04 01:44:44',
    'status' => '1',
  ),
  4 => 
  array (
    'id' => '5',
    'master_config_idName' => 'PAYMENT',
    'last_key' => '1968',
    'prefix' => 'PA',
    'sep' => '',
    'is_year_append' => '1',
    'is_month_append' => '1',
    'padding' => '4',
    'last_update_on' => '2025-01-28 16:23:41',
    'status' => '1',
  ),
  5 => 
  array (
    'id' => '6',
    'master_config_idName' => 'RECEIPT',
    'last_key' => '1000',
    'prefix' => 'REC',
    'sep' => NULL,
    'is_year_append' => '1',
    'is_month_append' => '1',
    'padding' => '4',
    'last_update_on' => '2025-01-28 16:23:41',
    'status' => '1',
  ),
  6 => 
  array (
    'id' => '7',
    'master_config_idName' => 'PRESCRIPTION',
    'last_key' => '1000',
    'prefix' => 'PRES',
    'sep' => NULL,
    'is_year_append' => '1',
    'is_month_append' => '1',
    'padding' => NULL,
    'last_update_on' => '2025-01-31 10:50:49',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('master_config_id');
    }
}

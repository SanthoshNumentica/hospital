<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayment_typeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'payment_typeName' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payment_type');

        // Insert initial data
        $this->db->table('payment_type')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'payment_typeName' => 'Cash',
    'status' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'payment_typeName' => 'Net Transfer',
    'status' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'payment_typeName' => 'UPI',
    'status' => '1',
  ),
  3 => 
  array (
    'id' => '4',
    'payment_typeName' => 'Chekque',
    'status' => '1',
  ),
  4 => 
  array (
    'id' => '5',
    'payment_typeName' => 'DD',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('payment_type');
    }
}

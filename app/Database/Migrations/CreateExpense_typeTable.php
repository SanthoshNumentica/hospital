<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExpense_typeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'expense_typeName' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('expense_type');

        // Insert initial data
        $this->db->table('expense_type')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'expense_typeName' => 'General',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('expense_type');
    }
}

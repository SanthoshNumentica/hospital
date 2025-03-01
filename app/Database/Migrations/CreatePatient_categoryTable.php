<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_categoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'patient_categoryName' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => false,
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
            'discount_type' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'discount_value' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'max_discount_amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_category');
    }

    public function down()
    {
        $this->forge->dropTable('patient_category');
    }
}

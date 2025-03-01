<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_investigationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'patient_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'temp' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'weight' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'bp' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'observation' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'blood_sugar' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_investigation');
    }

    public function down()
    {
        $this->forge->dropTable('patient_investigation');
    }
}

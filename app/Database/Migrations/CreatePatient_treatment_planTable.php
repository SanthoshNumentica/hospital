<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_treatment_planTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'patient_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'notes' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'treatment_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'teeth_number' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_treatment_plan');
    }

    public function down()
    {
        $this->forge->dropTable('patient_treatment_plan');
    }
}

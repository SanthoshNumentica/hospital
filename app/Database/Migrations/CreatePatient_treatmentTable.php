<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_treatmentTable extends Migration
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
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'treatment_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 245,
                'null' => true,
            ],
            'invoice_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'doctor_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_treatment');
    }

    public function down()
    {
        $this->forge->dropTable('patient_treatment');
    }
}

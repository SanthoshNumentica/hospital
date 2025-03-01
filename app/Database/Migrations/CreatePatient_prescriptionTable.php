<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_prescriptionTable extends Migration
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
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'visits_on' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
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
            'prescription_notes' => [
                'type' => 'VARCHAR',
                'constraint' => 245,
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_prescription');
    }

    public function down()
    {
        $this->forge->dropTable('patient_prescription');
    }
}

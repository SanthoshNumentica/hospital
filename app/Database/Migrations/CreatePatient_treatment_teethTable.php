<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_treatment_teethTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'patient_treatment_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'teethNumber' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_treatment_teeth');
    }

    public function down()
    {
        $this->forge->dropTable('patient_treatment_teeth');
    }
}

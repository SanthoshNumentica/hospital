<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_treatment_stepTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'patient_treatment_stepName' => [
                'type' => 'VARCHAR',
                'constraint' => 245,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'patient_treatment_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_treatment_step');
    }

    public function down()
    {
        $this->forge->dropTable('patient_treatment_step');
    }
}

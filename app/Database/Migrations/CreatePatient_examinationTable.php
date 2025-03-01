<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_examinationTable extends Migration
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
            'examination_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 345,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'teethNumber' => [
                'type' => 'INT',
                'constraint' => 11,
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_examination');
    }

    public function down()
    {
        $this->forge->dropTable('patient_examination');
    }
}

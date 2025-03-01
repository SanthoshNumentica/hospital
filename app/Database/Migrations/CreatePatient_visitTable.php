<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_visitTable extends Migration
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
            'visit_on' => [
                'type' => 'DATETIME',
                'constraint' => null,
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
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'token_no' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'doctor_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'counter_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_visit');
    }

    public function down()
    {
        $this->forge->dropTable('patient_visit');
    }
}

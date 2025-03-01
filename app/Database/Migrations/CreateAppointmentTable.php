<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentTable extends Migration
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
            'doctor_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'appointment_for' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'appointment_on' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'is_rescheduled' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'rescheduled_reason' => [
                'type' => 'VARCHAR',
                'constraint' => 75,
                'null' => true,
            ],
            'is_visited' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 125,
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
            'to_date' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('appointment');
    }

    public function down()
    {
        $this->forge->dropTable('appointment');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_prescription_itemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'medicine' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => false,
            ],
            'frequency' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'dosage' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'm_type' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'duration' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'notes' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'patient_prescription_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_prescription_item');
    }

    public function down()
    {
        $this->forge->dropTable('patient_prescription_item');
    }
}

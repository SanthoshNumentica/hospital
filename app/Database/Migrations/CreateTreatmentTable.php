<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTreatmentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'treatmentName' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => false,
            ],
            'is_not_treatment' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'is_chart' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'treatment_code' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'amount' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'examination_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('treatment');
    }

    public function down()
    {
        $this->forge->dropTable('treatment');
    }
}

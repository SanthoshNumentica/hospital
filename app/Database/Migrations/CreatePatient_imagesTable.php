<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatient_imagesTable extends Migration
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
                'constraint' => 4,
                'null' => false,
            ],
            'document' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient_images');
    }

    public function down()
    {
        $this->forge->dropTable('patient_images');
    }
}

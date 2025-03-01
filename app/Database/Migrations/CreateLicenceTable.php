<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLicenceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'licence_key' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'start_date' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'expire_date' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'licence_type' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
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
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('licence');
    }

    public function down()
    {
        $this->forge->dropTable('licence');
    }
}

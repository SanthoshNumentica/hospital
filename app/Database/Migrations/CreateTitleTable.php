<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTitleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'titleName' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('title');
    }

    public function down()
    {
        $this->forge->dropTable('title');
    }
}

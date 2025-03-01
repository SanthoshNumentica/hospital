<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'vendorName' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('vendor');
    }

    public function down()
    {
        $this->forge->dropTable('vendor');
    }
}

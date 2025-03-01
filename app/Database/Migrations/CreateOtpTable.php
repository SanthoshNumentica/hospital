<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtpTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false,
            ],
            'otp' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'otp_tries' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('otp');
    }

    public function down()
    {
        $this->forge->dropTable('otp');
    }
}

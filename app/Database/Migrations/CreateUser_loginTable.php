<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUser_loginTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'is_doctor' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 105,
                'null' => true,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'reset_password' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'forgot_password' => [
                'type' => 'VARCHAR',
                'constraint' => null,
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
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'last_login_date' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'fname' => [
                'type' => 'VARCHAR',
                'constraint' => 55,
                'null' => true,
            ],
            'lname' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 55,
                'null' => true,
            ],
            'last_reset_password' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'app_version' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'temp_block' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'block_reason' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'specialization' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'color_code' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'gender' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'counter_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_login');
    }

    public function down()
    {
        $this->forge->dropTable('user_login');
    }
}

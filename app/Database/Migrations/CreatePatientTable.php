<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatientTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'patient_id' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'title_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'f_name' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
            ],
            'l_name' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
            ],
            'blood_group_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'dob' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => true,
            ],
            'state_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => true,
            ],
            'gender_fk_id' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'chief_complaint' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
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
            'remarks' => [
                'type' => 'VARCHAR',
                'constraint' => 245,
                'null' => true,
            ],
            'allow_sms' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'last_visit' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'patient_category_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patient');
    }

    public function down()
    {
        $this->forge->dropTable('patient');
    }
}

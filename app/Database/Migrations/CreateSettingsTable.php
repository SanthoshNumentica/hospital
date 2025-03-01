<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'companyName' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'logo_white' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 350,
                'null' => true,
            ],
            'address_1' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'address_2' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'alt_mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'master_passcode' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'allow_notification' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'idl_timeout' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'website_url' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'logo_water_mark' => [
                'type' => 'VARCHAR',
                'constraint' => 245,
                'null' => true,
            ],
            'theme_color' => [
                'type' => 'VARCHAR',
                'constraint' => 125,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}

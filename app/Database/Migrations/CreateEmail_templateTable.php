<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmail_templateTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'event_name' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'body' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => false,
            ],
            'parameter' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'template_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'cc' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'bcc' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'module_id' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
            'pdf_content' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'event_des' => [
                'type' => 'VARCHAR',
                'constraint' => 55,
                'null' => true,
            ],
            'is_attach_pdf' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'cc_event' => [
                'type' => 'VARCHAR',
                'constraint' => 155,
                'null' => true,
            ],
            'allow_to_send_email' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'to_event' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'allow_send_sms' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'allow_send_whatsapp' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('email_template');
    }

    public function down()
    {
        $this->forge->dropTable('email_template');
    }
}

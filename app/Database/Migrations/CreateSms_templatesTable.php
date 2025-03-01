<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSms_templatesTable extends Migration
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
                'constraint' => 65,
                'null' => true,
            ],
            'template_content' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'parameter' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'allow_to_send' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'sender_id' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'whatsapp_template_content' => [
                'type' => 'VARCHAR',
                'constraint' => 300,
                'null' => true,
            ],
            'whatsapp_content' => [
                'type' => 'VARCHAR',
                'constraint' => null,
                'null' => true,
            ],
            'module_id' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sms_templates');

        // Insert initial data
        $this->db->table('sms_templates')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'event_name' => 'NEW_PATIENT',
    'template_content' => 'Dear {patientName}, Warm wishes from SI-DENT Dental Clinic. Your ID No is: {patient_id} We care for your smile. Have a better tomorrow. For appointments Contact 04652-265633. For Emergency 7708833633.',
    'parameter' => 'patientName,patient_id',
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => 'GEMSFO',
    'whatsapp_template_content' => '{otp} is your OTP for account login in GEMS Portal. This OTP is valid for the next 5 minutes. Do not share this OTP with anyone - GEMSFO',
    'whatsapp_content' => 'test',
    'module_id' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'event_name' => 'APPOINTMENT',
    'template_content' => 'Hello {patientName}, your appointment with {doctorName} is scheduled on {appointment_date}{appointment_time}.  – [SI]',
    'parameter' => 'patientName,doctorName,appointmentDate,appointment_time,address',
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => 'SMS',
    'whatsapp_template_content' => '2',
    'whatsapp_content' => '0',
    'module_id' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'event_name' => 'APPOINTMNET_REMINDER',
    'template_content' => 'Hello {patientName}, your appointment with {doctorName} is scheduled on {appointment_date}{appointment_time}.  – [SI DENTAL]',
    'parameter' => 'patientName,doctorName,appointmentDate,appointment_time,address',
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => 'WHATSAPP',
    'whatsapp_template_content' => '1',
    'whatsapp_content' => '0',
    'module_id' => '1',
  ),
  3 => 
  array (
    'id' => '4',
    'event_name' => 'NEW_APPOINTMENT',
    'template_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'parameter' => 'doctorName,appointment_on,appointment_for',
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => NULL,
    'whatsapp_template_content' => '1',
    'whatsapp_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'module_id' => '1',
  ),
  4 => 
  array (
    'id' => '5',
    'event_name' => 'RESCHEDULE_APPOINTMENT',
    'template_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'parameter' => '',
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => NULL,
    'whatsapp_template_content' => '1',
    'whatsapp_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'module_id' => '1',
  ),
  5 => 
  array (
    'id' => '6',
    'event_name' => 'NEW_INVOICE',
    'template_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'parameter' => NULL,
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => NULL,
    'whatsapp_template_content' => '1',
    'whatsapp_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'module_id' => '1',
  ),
  6 => 
  array (
    'id' => '7',
    'event_name' => 'NEW_PAYMENT',
    'template_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'parameter' => NULL,
    'allow_to_send' => '0',
    'status' => '1',
    'sender_id' => NULL,
    'whatsapp_template_content' => '1',
    'whatsapp_content' => 'Greetings from SIDENT Dental Clinic. Your appointment is scheduled on  {appointment_on}  Kindly let us know if there is any inconvenience at 04652 265633',
    'module_id' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('sms_templates');
    }
}

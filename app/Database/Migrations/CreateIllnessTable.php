<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIllnessTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'illnessName' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => false,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('illness');

        // Insert initial data
        $this->db->table('illness')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'illnessName' => 'Allergy',
    'status' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'illnessName' => 'Myocardial Infarction',
    'status' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'illnessName' => 'Hypertension',
    'status' => '1',
  ),
  3 => 
  array (
    'id' => '4',
    'illnessName' => 'Diabetes',
    'status' => '1',
  ),
  4 => 
  array (
    'id' => '5',
    'illnessName' => 'Congenital Heart Disease',
    'status' => '1',
  ),
  5 => 
  array (
    'id' => '6',
    'illnessName' => 'Seizures',
    'status' => '1',
  ),
  6 => 
  array (
    'id' => '7',
    'illnessName' => 'Hyper Thyroidism',
    'status' => '1',
  ),
  7 => 
  array (
    'id' => '8',
    'illnessName' => 'Peptic Ulcer',
    'status' => '1',
  ),
  8 => 
  array (
    'id' => '9',
    'illnessName' => 'Hepatitis',
    'status' => '1',
  ),
  9 => 
  array (
    'id' => '10',
    'illnessName' => 'Allergic to Penicillin',
    'status' => '1',
  ),
  10 => 
  array (
    'id' => '11',
    'illnessName' => 'Allergic to Dust',
    'status' => '1',
  ),
  11 => 
  array (
    'id' => '12',
    'illnessName' => 'Allergic to Paracetamol',
    'status' => '1',
  ),
  12 => 
  array (
    'id' => '13',
    'illnessName' => 'Allergic to Diclofenac',
    'status' => '1',
  ),
  13 => 
  array (
    'id' => '14',
    'illnessName' => 'Cardiac Myopathy',
    'status' => '1',
  ),
  14 => 
  array (
    'id' => '15',
    'illnessName' => 'TB Patient',
    'status' => '1',
  ),
  15 => 
  array (
    'id' => '16',
    'illnessName' => 'Allergic to Brufen',
    'status' => '1',
  ),
  16 => 
  array (
    'id' => '17',
    'illnessName' => 'Asthmatic',
    'status' => '1',
  ),
  17 => 
  array (
    'id' => '18',
    'illnessName' => 'Allergic to Sulpha',
    'status' => '1',
  ),
  18 => 
  array (
    'id' => '19',
    'illnessName' => 'Allergic to   Gatifloxacin',
    'status' => '1',
  ),
  19 => 
  array (
    'id' => '20',
    'illnessName' => 'Allergic to Piroxicam',
    'status' => '1',
  ),
  20 => 
  array (
    'id' => '21',
    'illnessName' => 'Allergic to Ciprofloxacin',
    'status' => '1',
  ),
  21 => 
  array (
    'id' => '22',
    'illnessName' => 'allergic to ketarol',
    'status' => '1',
  ),
  22 => 
  array (
    'id' => '23',
    'illnessName' => 'Asthma',
    'status' => '1',
  ),
  23 => 
  array (
    'id' => '24',
    'illnessName' => 'Cholestrol',
    'status' => '1',
  ),
  24 => 
  array (
    'id' => '25',
    'illnessName' => 'Hypo thyrodisam',
    'status' => '1',
  ),
  25 => 
  array (
    'id' => '26',
    'illnessName' => 'Allergic to Ketorol',
    'status' => '1',
  ),
  26 => 
  array (
    'id' => '27',
    'illnessName' => 'On Dialysis',
    'status' => '1',
  ),
  27 => 
  array (
    'id' => '28',
    'illnessName' => 'Renal Disorder',
    'status' => '1',
  ),
  28 => 
  array (
    'id' => '29',
    'illnessName' => 'Hepatic disorder',
    'status' => '1',
  ),
  29 => 
  array (
    'id' => '30',
    'illnessName' => 'Arthritis',
    'status' => '1',
  ),
  30 => 
  array (
    'id' => '31',
    'illnessName' => 'Cerebral Palsy',
    'status' => '1',
  ),
  31 => 
  array (
    'id' => '32',
    'illnessName' => 'Cardiac Disorder',
    'status' => '1',
  ),
  32 => 
  array (
    'id' => '33',
    'illnessName' => 'On Anticoyagulant',
    'status' => '1',
  ),
  33 => 
  array (
    'id' => '34',
    'illnessName' => 'Under Chemotherapy',
    'status' => '1',
  ),
  34 => 
  array (
    'id' => '35',
    'illnessName' => 'On Pacemaker',
    'status' => '1',
  ),
  35 => 
  array (
    'id' => '36',
    'illnessName' => 'Allergic to Metronidazole',
    'status' => '1',
  ),
  36 => 
  array (
    'id' => '37',
    'illnessName' => 'Hypo Thyrodism',
    'status' => '1',
  ),
  37 => 
  array (
    'id' => '38',
    'illnessName' => 'Parkinson Disease',
    'status' => '1',
  ),
  38 => 
  array (
    'id' => '8735',
    'illnessName' => 'k',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('illness');
    }
}

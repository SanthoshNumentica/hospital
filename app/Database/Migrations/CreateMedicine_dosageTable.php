<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicine_dosageTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'medicine_dosageName' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 4,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('medicine_dosage');

        // Insert initial data
        $this->db->table('medicine_dosage')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'medicine_dosageName' => '10 g',
    'status' => '1',
    'created_at' => '2024-05-30 11:11:37',
  ),
  1 => 
  array (
    'id' => '2',
    'medicine_dosageName' => '15 g',
    'status' => '1',
    'created_at' => '2024-05-30 11:11:44',
  ),
  2 => 
  array (
    'id' => '3',
    'medicine_dosageName' => '100 g',
    'status' => '1',
    'created_at' => '2024-05-30 11:12:41',
  ),
  3 => 
  array (
    'id' => '4',
    'medicine_dosageName' => '200 g',
    'status' => '1',
    'created_at' => '2024-05-30 11:13:08',
  ),
  4 => 
  array (
    'id' => '5',
    'medicine_dosageName' => '10 ml',
    'status' => '1',
    'created_at' => '2024-05-30 11:16:15',
  ),
  5 => 
  array (
    'id' => '6',
    'medicine_dosageName' => '20 ml',
    'status' => '1',
    'created_at' => '2024-05-30 11:19:21',
  ),
  6 => 
  array (
    'id' => '7',
    'medicine_dosageName' => '10 mg',
    'status' => '1',
    'created_at' => '2024-05-30 11:21:36',
  ),
  7 => 
  array (
    'id' => '9',
    'medicine_dosageName' => '500MG',
    'status' => '1',
    'created_at' => '2024-05-30 18:39:37',
  ),
  8 => 
  array (
    'id' => '10',
    'medicine_dosageName' => '400MG',
    'status' => '1',
    'created_at' => '2024-05-30 18:40:45',
  ),
  9 => 
  array (
    'id' => '11',
    'medicine_dosageName' => '250ML',
    'status' => '1',
    'created_at' => '2024-05-30 18:40:56',
  ),
  10 => 
  array (
    'id' => '12',
    'medicine_dosageName' => '30ML',
    'status' => '1',
    'created_at' => '2024-05-30 18:41:05',
  ),
  11 => 
  array (
    'id' => '13',
    'medicine_dosageName' => '625',
    'status' => '1',
    'created_at' => '2024-05-30 18:41:14',
  ),
  12 => 
  array (
    'id' => '14',
    'medicine_dosageName' => '50MG',
    'status' => '1',
    'created_at' => '2024-05-30 18:41:39',
  ),
  13 => 
  array (
    'id' => '15',
    'medicine_dosageName' => '425MG',
    'status' => '1',
    'created_at' => '2024-05-30 18:57:21',
  ),
  14 => 
  array (
    'id' => '16',
    'medicine_dosageName' => '200MG',
    'status' => '1',
    'created_at' => '2024-05-30 18:57:36',
  ),
  15 => 
  array (
    'id' => '17',
    'medicine_dosageName' => '625MG',
    'status' => '1',
    'created_at' => '2024-05-30 18:58:21',
  ),
  16 => 
  array (
    'id' => '18',
    'medicine_dosageName' => '100G',
    'status' => '1',
    'created_at' => '2024-05-30 19:18:56',
  ),
  17 => 
  array (
    'id' => '19',
    'medicine_dosageName' => '50G',
    'status' => '1',
    'created_at' => '2024-05-30 19:19:14',
  ),
  18 => 
  array (
    'id' => '20',
    'medicine_dosageName' => '70G',
    'status' => '1',
    'created_at' => '2024-05-30 19:19:22',
  ),
  19 => 
  array (
    'id' => '21',
    'medicine_dosageName' => '1000G',
    'status' => '1',
    'created_at' => '2024-05-30 19:20:38',
  ),
  20 => 
  array (
    'id' => '22',
    'medicine_dosageName' => '40MG',
    'status' => '1',
    'created_at' => '2024-05-30 19:25:33',
  ),
  21 => 
  array (
    'id' => '23',
    'medicine_dosageName' => '50ml',
    'status' => '1',
    'created_at' => '2024-06-04 18:16:12',
  ),
  22 => 
  array (
    'id' => '24',
    'medicine_dosageName' => '5G',
    'status' => '1',
    'created_at' => '2024-06-24 14:13:20',
  ),
  23 => 
  array (
    'id' => '25',
    'medicine_dosageName' => '475MG',
    'status' => '1',
    'created_at' => '2024-06-25 14:32:09',
  ),
  24 => 
  array (
    'id' => '26',
    'medicine_dosageName' => '48MG',
    'status' => '1',
    'created_at' => '2024-06-29 19:49:46',
  ),
  25 => 
  array (
    'id' => '27',
    'medicine_dosageName' => '100MG',
    'status' => '1',
    'created_at' => '2024-07-06 21:04:08',
  ),
  26 => 
  array (
    'id' => '28',
    'medicine_dosageName' => '475G',
    'status' => '1',
    'created_at' => '2024-07-09 19:42:30',
  ),
  27 => 
  array (
    'id' => '29',
    'medicine_dosageName' => '110ML',
    'status' => '1',
    'created_at' => '2024-07-13 13:16:48',
  ),
  28 => 
  array (
    'id' => '30',
    'medicine_dosageName' => '70',
    'status' => '1',
    'created_at' => '2024-07-17 19:31:03',
  ),
  29 => 
  array (
    'id' => '31',
    'medicine_dosageName' => '625CV',
    'status' => '1',
    'created_at' => '2024-07-27 11:24:36',
  ),
  30 => 
  array (
    'id' => '32',
    'medicine_dosageName' => '75G',
    'status' => '1',
    'created_at' => '2024-09-03 13:27:17',
  ),
  31 => 
  array (
    'id' => '33',
    'medicine_dosageName' => '5MG',
    'status' => '1',
    'created_at' => '2024-09-12 20:49:34',
  ),
  32 => 
  array (
    'id' => '34',
    'medicine_dosageName' => '80ML',
    'status' => '1',
    'created_at' => '2024-09-19 15:00:19',
  ),
  33 => 
  array (
    'id' => '35',
    'medicine_dosageName' => '50',
    'status' => '1',
    'created_at' => '2024-09-21 17:35:05',
  ),
  34 => 
  array (
    'id' => '36',
    'medicine_dosageName' => '120ML',
    'status' => '1',
    'created_at' => '2024-09-24 20:39:17',
  ),
  35 => 
  array (
    'id' => '37',
    'medicine_dosageName' => '375MG',
    'status' => '1',
    'created_at' => '2024-10-14 14:22:31',
  ),
  36 => 
  array (
    'id' => '38',
    'medicine_dosageName' => '1000MG',
    'status' => '1',
    'created_at' => '2024-11-04 12:07:13',
  ),
  37 => 
  array (
    'id' => '39',
    'medicine_dosageName' => '200 MG',
    'status' => '1',
    'created_at' => '2024-11-26 12:27:21',
  ),
  38 => 
  array (
    'id' => '40',
    'medicine_dosageName' => '650MG',
    'status' => '1',
    'created_at' => '2024-12-19 20:23:51',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('medicine_dosage');
    }
}
